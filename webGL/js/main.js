import * as THREE from './libs/three.module.js';
import {THREEx} from './libs/THREEx.KeyboardState.js';
import Stats from './libs/stats.module.js';
import * as functions from './functions.js';
import * as city_builder from './city_builder.js';
import {FBXLoader} from "./libs/FBXLoader.js";

Math.radians = (degrees) => degrees * Math.PI / 180;

let keyboard = new THREEx.KeyboardState(); // import de la librairie qui écoute le clavier
let camera, geometry, light1, renderer, scene, stats, terrain, pivot;
const loader = new THREE.TextureLoader();


let terrainDim = {
    width: 1000, //pas de 250
    height: 1000, //pas de 250
};

let cameraT = {
    moveSpeed: 1,
    rotationSpeed: 0.05
};


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
    camera.rotation.x = -0.38;
    pivot = new THREE.Group();
    pivot.position.set(-10, 1, 550);

    pivot.add(camera);
    camera.position.set(0, 80, 80)

    scene.add(pivot);

    let fbxLoader =  new FBXLoader();
    fbxLoader.load('../assets/models/Vehicles_HotdogTruck.fbx', function (object) {
        object.scale.x = object.scale.y = object.scale.z = 0.05;
        object.name = "food_truck";
        pivot.add(object);

        object.traverse(function (child) {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
    })

    scene.background = loader.load('../assets/images/sky.jpg');

    /**
     * Build city
     */

    city_builder.build_city(scene, terrainDim);

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