import * as THREE from './libs/three.module.js';
import {FBXLoader} from "./libs/FBXLoader.js";
import {TGALoader} from "./libs/TGALoader.js";


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

export function camControl(keyboard, group, cameraT, truckPivot, terrainDim) {
    let vectorX = new THREE.Vector3(1, 0, 0);
    let vectorY = new THREE.Vector3(0, 1, 0);
    let vectorZ = new THREE.Vector3(0, 0, 1);
    let truck = group.getObjectByName("food_truck");
    // console.log("Position, x:" + group.position.x + ", z:" + group.position.z);

    /*
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
    */

    if (keyboard.pressed("z")) {
        group.translateZ(-cameraT.moveSpeed);
    }
    if (keyboard.pressed("s")) {
        group.translateZ(cameraT.moveSpeed);
    }
    if (keyboard.pressed("q")) {
        // camera.translateX(-cameraT.moveSpeed);
        group.rotateOnAxis(vectorY, cameraT.rotationSpeed);
        truck.rotation.y += truckPivot;
    } else if (truck.rotation.y > 0) {
        truck.rotation.y -= truckPivot * 2;
    }
    if (keyboard.pressed("d")) {
        // camera.translateX(cameraT.moveSpeed);
        group.rotateOnAxis(vectorY, -cameraT.rotationSpeed);
        truck.rotation.y -= truckPivot;
    } else if (truck.rotation.y < 0) {
        truck.rotation.y += truckPivot * 2;
    }

    if (keyboard.pressed("a")) {
        group.rotateOnAxis(vectorZ, cameraT.rotationSpeed * 0.5);
    }
    if (keyboard.pressed("e")) {
        group.rotateOnAxis(vectorZ, -cameraT.rotationSpeed * 0.5);
    }
    group.position.y = 1;
    terrainLimitCollider(group, terrainDim);
}

export function terrainLimitCollider(object, terrainDim) {

    object.position.x = Math.max(object.position.x, -terrainDim.width / 2 + 5);
    object.position.x = Math.min(object.position.x, terrainDim.width / 2 + 20);
    object.position.z = Math.max(object.position.z, -terrainDim.height / 2 + 5);
    object.position.z = Math.min(object.position.z, terrainDim.height / 2 + 20);
}

export function loadStaticFBX(scene, path = null, name = "", scale = 1, posX = 0, posY = 0, posZ = 0, rotY = 0, transparency = false) {
    let manager = new THREE.LoadingManager();
    manager.addHandler(/\.tga$/i, new TGALoader());
    let loader = new FBXLoader(manager);
    loader.load(path, function (object) {

        object.traverse(function (child) {

            if (child.isMesh) {
                if (transparency) {
                    child.material.transparent = true;
                    child.material.alphaTest = 0.5;
                }

                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
        object.name = name;
        object.position.set(posX, posY, posZ)
        object.rotateY(rotY);
        object.scale.x = object.scale.y = object.scale.z = scale;
        scene.add(object);
    });
}

export function updateArrow(arrow, object) {
    arrow.lookAt(object.position.x, 30, object.position.z);
    arrow.rotation.y += Math.radians(180);
    arrow.rotation.z += Math.radians(90);

}

