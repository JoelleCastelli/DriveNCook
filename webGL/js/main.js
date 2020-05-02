import * as THREE from './libs/three.module.js';
import {THREEx} from './libs/THREEx.KeyboardState.js';
import Stats from './libs/stats.module.js';

Math.radians = (degrees) => degrees * Math.PI / 180;

let keyboard = new THREEx.KeyboardState(); // import de la librairie qui écoute le clavier
let camera, geometry, renderer, scene, stats, terrain;
let vectorX = new THREE.Vector3(1, 0, 0);
let vectorY = new THREE.Vector3(0, 1, 0);
let vectorZ = new THREE.Vector3(0, 0, 1);

let terrainDim = {
    width: 100,
    height: 100,
};

let cameraT = {
    moveSpeed: 1,
    rotationSpeed: 0.01
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
    camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, terrainDim.width + terrainDim.height)
    camera.position.set(terrainDim.width / 2, terrainDim.height / 2, 10);

    /**
     * init terrain
     */
    geometry = new THREE.PlaneBufferGeometry(terrainDim.width, terrainDim.height, 32, 32);
    terrain = new THREE.Mesh(geometry, greenMat);
    terrain.receiveShadow = true;
    terrain.position.set(terrainDim.width / 2, terrainDim.height / 2, -80)
    scene.add(terrain);


    /**
     * light
     */
    geometry = new THREE.SphereBufferGeometry(2, 32, 32);
    var light1 = new THREE.PointLight(0xFFFFFF, 0.5);
    light1.add(new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({color: 0xFFFFFF})));
    light1.position.set(0, 20, 0);
    light1.castShadow = true;
    scene.add(light1);

    /**
     * render options
     */
    renderer = new THREE.WebGLRenderer({antialias: true});
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
    camControl()
    render();
}

function render() {
    stats.update();
    renderer.render(scene, camera);
}

function camControl() {

    if (keyboard.pressed("up")) {
        if (camera.rotation.x < Math.radians(40)) {
            camera.rotateOnAxis(vectorX, cameraT.rotationSpeed);
        }
    }
    if (keyboard.pressed("down")) {
        if (camera.rotation.x > Math.radians(-40)) {
            camera.rotateOnAxis(vectorX, -cameraT.rotationSpeed);
        }
    }
    if (keyboard.pressed("left")) {
        camera.rotateOnAxis(vectorY, cameraT.rotationSpeed);
    }
    if (keyboard.pressed("right")) {
        camera.rotateOnAxis(vectorY, -cameraT.rotationSpeed);
    }
    if (keyboard.pressed("z")) {
        camera.translateZ(-cameraT.moveSpeed);
    }
    if (keyboard.pressed("s")) {
        camera.translateZ(cameraT.moveSpeed);
    }
    if (keyboard.pressed("q")) {
        camera.translateX(-cameraT.moveSpeed);
    }
    if (keyboard.pressed("d")) {
        camera.translateX(cameraT.moveSpeed);
    }
    if (keyboard.pressed("a")) {
        camera.rotateOnAxis(vectorZ, cameraT.rotationSpeed * 0.5);
    }
    if (keyboard.pressed("e")) {
        camera.rotateOnAxis(vectorZ, -cameraT.rotationSpeed * 0.5);
    }
}
