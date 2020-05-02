import * as THREE from './libs/three.module.js';
import Stats from './libs/stats.module.js';

Math.radians = (degrees) => degrees * Math.PI / 180;

var camera, geometry, renderer, scene, stats, terrain;

var terrainDim = {
    width: 100,
    height: 100,
};

var cameraPos = {
    x: terrainDim.width / 2,
    y: terrainDim.height / 2,
    z: 10
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
    camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 1, terrainDim.width + terrainDim.height)
    camera.position.set(cameraPos.x, cameraPos.y, cameraPos.z);

    /**
     * init terrain
     */
    geometry = new THREE.PlaneBufferGeometry(terrainDim.width, terrainDim.height, 32, 32);
    terrain = new THREE.Mesh(geometry, greenMat);
    terrain.receiveShadow = true;
    terrain.position.set(terrainDim.width/2, terrainDim.height/2, -80)
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
    render();
}

function render() {
    stats.update();
    renderer.render(scene, camera);
}