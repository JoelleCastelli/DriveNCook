import * as THREE from './libs/three.module.js';
import * as functions from './functions.js';
import {FBXLoader} from "./libs/FBXLoader.js";


const food = [
    '../assets/models/SM_Prop_LargeSign_Burger_01.fbx',
    '../assets/models/SM_Prop_LargeSign_Hotdog_01.fbx',
    '../assets/models/SM_Prop_LargeSign_Icecream_01.fbx',
    '../assets/models/SM_Prop_LargeSign_Pizza_01.fbx',
    '../assets/models/SM_Prop_LargeSign_Soda_01.fbx',
    '../assets/models/SM_Prop_LargeSign_Taco_01.fbx',
];

const foodPos = [
    [-5.2, 513.5],
    [0, 250],
    [-224.9, 276.1],
    [-224, 4],
    [6.1, -102.7],
    [-282.5, -257],
    [-329, 10.7],
];

let clock = new THREE.Clock();
let idleAnimationMixer = undefined;

const character = [
    '../assets/models/Character_BusinessWoman_01.fbx',
    '../assets/models/Character_Female_Jacket_01.fbx',
    '../assets/models/Character_Male_Hoodie_01.fbx',
    '../assets/models/Character_Male_Jacket_01.fbx',

];
let characterPosR;
let characterAnimC;
const characterPos = [
    [-310, 490.8],
    [-307.4, -6.4],
    [-286.4, -256.9],
    [341.3, -254.2],
];

export function updateGame(pivot, scene, objectName) {
    switch (objectName) {
        case "food":
            objectName = updateGameFoodCase(pivot, scene, objectName);
            break;
        case "initFood":
            let foodPosR = THREE.Math.randInt(0, foodPos.length - 1);
            objectName = initFood(scene, foodPos[foodPosR][0], foodPos[foodPosR][1]);
            break;
        case "person":
            objectName = updateGamePersonCase(pivot, scene, objectName);
            break;
        case "initPerson":
            characterPosR = THREE.Math.randInt(0, characterPos.length - 1);
            objectName = initPerson(scene, characterPos[characterPosR][0], characterPos[characterPosR][1]);
            break;
    }
    return objectName;
}

export function initFood(scene, posX, posZ) {
    let fbxLoader = new FBXLoader();
    let foodN = THREE.Math.randInt(0, food.length - 1);
    fbxLoader.load(food[foodN], function (object) {
        object.scale.x = object.scale.y = object.scale.z = 0.05;
        object.position.set(posX, 10, posZ);
        object.name = "food";
        scene.add(object)
        object.traverse(function (child) {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
    })
    return "food";
}

export function initPerson(scene, posX, posZ) {
    characterAnimC = 0;
    let fbxLoader = new FBXLoader();
    let characterN = THREE.Math.randInt(0, character.length - 1);
    fbxLoader.load(character[characterN], function (object) {
        object.scale.x = object.scale.y = object.scale.z = 0.1;
        object.position.set(posX, 0, posZ);
        object.name = "person";
        scene.add(object)
        object.traverse(function (child) {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
    })
    return "person";
}

export function updateGameFoodCase(pivot, scene, objectName) {
    animateFood(objectName, scene);

    let arrow = pivot.getObjectByName("arrow");
    let food = scene.getObjectByName(objectName);

    if (arrow !== undefined && food !== undefined) {
        functions.updateArrow(arrow, food);
        if (detectColision(pivot, food, 20)) {
            scene.remove(food);
            return "initPerson";
        }
    }
    return "food";
}

export function updateGamePersonCase(pivot, scene, objectName) {

    let arrow = pivot.getObjectByName("arrow");
    let person = scene.getObjectByName(objectName);

    if (arrow !== undefined && person !== undefined) {
        functions.updateArrow(arrow, person);
        updateCharacterAnimation(person)
        if (detectColision(pivot, person, 20)) {
            scene.remove(person);
            idleAnimationMixer = undefined;
            return "initFood";
        }
    }
    return "person";
}

export function animateFood(objectName, scene) {
    let object = scene.getObjectByName(objectName);
    if (object !== undefined) {
        object.rotation.y += 0.01;
    }
}

export function detectColision(objectS, objectD, precision) {
    let positionA = objectS.position.clone();
    let positionB = objectD.position.clone();
    let diffX = positionA.x - positionB.x;
    let diffZ = positionA.z - positionB.z;

    return ((diffX > 0 && diffX < precision) || (diffX < 0 && diffX > -precision)) &&
        ((diffZ > 0 && diffZ < precision) || (diffZ < 0 && diffZ > -precision));
}

export function updateCharacterAnimation(character) {
    let delta = clock.getDelta();
    if (character !== undefined) {
        if (idleAnimationMixer === undefined) {
            idleAnimationMixer = new THREE.AnimationMixer(character);
        }
        let action = idleAnimationMixer.clipAction(character.animations[0]);

        action.play();
        if (idleAnimationMixer && characterAnimC < 1) {
            idleAnimationMixer.update(delta);
            characterAnimC++;
        }
    }
    character.position.x = characterPos[characterPosR][0];
    character.position.z = characterPos[characterPosR][1];
    character.position.y = 0;
}


