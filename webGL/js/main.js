import * as THREE from './libs/three.module.js';
import {THREEx} from './libs/THREEx.KeyboardState.js';
import Stats from './libs/stats.module.js';
import {GUI} from './libs/dat.gui.module.js';
import * as functions from './functions.js';
import * as city_builder from './city_builder.js';
import {FBXLoader} from "./libs/FBXLoader.js";

Math.radians = (degrees) => degrees * Math.PI / 180;

let keyboard = new THREEx.KeyboardState(); // import de la librairie qui écoute le clavier
let camera, geometry, light1, renderer, scene, stats, terrain, pivot, foodObjectName, gui;
const loader = new THREE.TextureLoader();

let listener = new THREE.AudioListener();
let sound = new THREE.Audio(listener);

let terrainDim = {
    width: 1000, //pas de 250
    height: 1000, //pas de 250
};

let cameraT = {
    moveSpeed: 1.5,
    rotationSpeed: 0.04
};

let guiParams = {
    score: 0,
    volume: 0.2,
    PlayPauseMusic: function () {
        if (sound.isPlaying) {
            sound.pause();
        } else {
            sound.play();
        }
    },
    RestartMusic: function () {
        sound.stop();
        sound.play();
    },
    blank: function () {
    }
}


const blackMat = new THREE.MeshStandardMaterial({color: 0x000000});
const whiteMat = new THREE.MeshStandardMaterial({color: 0xffffff});
const greenMat = new THREE.MeshStandardMaterial({color: 0x38FF00});


init();
animate();

function init() {
    stats = new Stats();
    document.body.appendChild(stats.dom);
    scene = new THREE.Scene();

    /**
     * init camera
     */
    camera = functions.createCamera(60, 1, 10000, 0, 0, 0);
    camera.rotation.x = -0.35;
    camera.add(listener);
    pivot = new THREE.Group();
    pivot.position.set(-10, 1, 550);

    pivot.add(camera);
    camera.position.set(0, 60, 60)

    scene.add(pivot);

    let fbxLoader = new FBXLoader();
    fbxLoader.load('../assets/models/Vehicles_HotdogTruck.fbx', function (object) {
        object.scale.x = object.scale.y = object.scale.z = 0.03;
        object.name = "food_truck";
        pivot.add(object);

        object.traverse(function (child) {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
    })

    fbxLoader.load('../assets/models/Arrow.fbx', function (object) {
        object.scale.x = object.scale.y = object.scale.z = 0.2;
        object.position.set(0, 30, 10);
        object.rotation.z += Math.radians(90);
        object.name = "arrow";
        pivot.add(object);
        object.traverse(function (child) {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
    });

    scene.background = loader.load('../assets/images/sky.jpg');

    /**
     * Build city
     */

    city_builder.build_city(scene, terrainDim);

    startGUI();
    /**
     * Init music
     */

    music();

    /**
     * render options
     */
    renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true,
    });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.shadowMap.enabled = true;
    renderer.domElement.id = 'canvas';
    document.body.appendChild(renderer.domElement);
    window.addEventListener('resize', onWindowResize, false);
    document.addEventListener('keydown', onLoad, false);

}

function onLoad() {
    const preload = document.querySelector('.container');
    const canvas = document.querySelector('#canvas');
    canvas.classList.add('display');
    preload.classList.add('container-finish');
}

function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

function animate() {
    requestAnimationFrame(animate);
    functions.camControl(keyboard, pivot, cameraT, scene);
    render();
}

function render() {
    stats.update();
    renderer.render(scene, camera);
}

function music() {
    let audioLoader = new THREE.AudioLoader();
    audioLoader.load('../assets/sound/catgroove.ogg', function (buffer) {
        sound.setBuffer(buffer);
        sound.setLoop(true);
        sound.setVolume(guiParams.volume);
        sound.play();
    })
}

function startGUI() {
    if (gui !== undefined) {
        gui.destroy();
    }
    gui = new GUI();
    gui.add(guiParams, 'PlayPauseMusic').name('Play/Pause music');
    gui.add(guiParams, 'RestartMusic').name('Restart music')
    gui.add(guiParams, 'volume').name('Music volume').min(0).max(2).step(0.1).onChange(function () {
        sound.setVolume(guiParams.volume);
    });

    gui.add(guiParams, 'blank').name("Score : " + guiParams.score);
    console.log(gui);
}

function updateScore() {
    gui.__controllers[3].remove();
    gui.add(guiParams, 'blank').name("Score : " + guiParams.score);
}