import * as THREE from './libs/three.module.js';

export function createCamera(
    fov = 60,
    near = 1,
    far = 10,
    posX = 0,
    posY = 0,
    posZ = 0) {

    let camera = new THREE.PerspectiveCamera(fov, window.innerWidth / window.innerHeight, near, far)
    camera.position.set(posX, posY, posZ);

    return camera;
}

export function createTerrain(
    width = 10,
    height = 10,
    mat = new THREE.MeshBasicMaterial({color: 0xFEFEFE}),
    posX = 0,
    posY = 0,
    posZ = 0) {

    let geometry = new THREE.PlaneBufferGeometry(width, height, 32, 32);
    let terrain = new THREE.Mesh(geometry, mat);
    terrain.receiveShadow = true;
    terrain.position.set(posX, posY, posZ);

    return terrain;
}

export function createPointLight(
    radius = 2,
    color = 0xFFFFFF,
    intensity = 1,
    posX = 0,
    posY = 0,
    posZ = 0) {

    let geometry = new THREE.SphereBufferGeometry(radius, 32, 32);
    let light = new THREE.PointLight(color, intensity, 1000);
    light.shadow.camera.far = 1500
    light.add(new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({color: color})));
    light.position.set(posX, posY, posZ);
    light.castShadow = true;

    return light;
}

export function camControl(keyboard, camera, cameraT) {
    let vectorX = new THREE.Vector3(1, 0, 0);
    let vectorY = new THREE.Vector3(0, 1, 0);
    let vectorZ = new THREE.Vector3(0, 0, 1);


    if (keyboard.pressed("up")) {
        // if (camera.rotation.x < Math.radians(40)) {
        camera.rotateOnAxis(vectorX, cameraT.rotationSpeed);
        // }
    }
    if (keyboard.pressed("down")) {
        // if (camera.rotation.x > Math.radians(-40)) {
        camera.rotateOnAxis(vectorX, -cameraT.rotationSpeed);
        // }
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
