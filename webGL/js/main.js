import * as THREE from './libs/three.module.js';
import {THREEx} from './libs/THREEx.KeyboardState.js';
import Stats from './libs/stats.module.js';
import * as functions from './functions.js';
import * as city_builder from './city_builder.js';

Math.radians = (degrees) => degrees * Math.PI / 180;

let keyboard = new THREEx.KeyboardState(); // import de la librairie qui écoute le clavier
let camera, geometry, light1, renderer, scene, stats, terrain;
const loader = new THREE.TextureLoader();

let terrainDim = {
    width: 1000, //pas de 250
    height: 1000, //pas de 250
};

let cameraT = {
    moveSpeed: 5,
    rotationSpeed: 0.03
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
    camera = functions.createCamera(60, 1, 10000,
        -34.45, 376, 913.7)
    camera.rotation.x = -0.36;

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
        alpha : true,
    });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.shadowMap.enabled = true;
    document.body.appendChild(renderer.domElement);
    window.addEventListener('resize', onWindowResize, false);
}

function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

function animate() {
    requestAnimationFrame(animate);
    functions.camControl(keyboard, camera, cameraT);
    render();
}

function render() {
    stats.update();
    renderer.render(scene, camera);
}