import * as THREE from './libs/three.module.js';
import * as functions from './functions.js';

Math.radians = (degrees) => degrees * Math.PI / 180;


const vehicles = {
    car_ambo: '../assets/models/SM_Veh_Car_Ambo_01.fbx',
    car_medium: '../assets/models/SM_Veh_Car_Medium_01.fbx',
    car_muscle: '../assets/models/SM_Veh_Car_Muscle_01.fbx',
    car_sedan: '../assets/models/SM_Veh_Car_Sedan_01.fbx',
    taxi: '../assets/models/SM_Veh_Car_Taxi_01.fbx',
    van: '../assets/models/SM_Veh_Car_Van_01.fbx',
    food_truck: '../assets/models/Vehicles_HotdogTruck.fbx'
}

const buildings = {
    apartment_01: '../assets/models/SM_Bld_Apartment_Stack_02.fbx',
    apartment_02: '../assets/models/SM_Bld_Apartment_Stack_03.fbx',
    office_octagon: '../assets/models/SM_Bld_OfficeOctagon_01.fbx',
    office_old_large: '../assets/models/SM_Bld_OfficeOld_Large_01.fbx',
    office_old_small_01: '../assets/models/SM_Bld_OfficeOld_Small_01.fbx',
    office_old_small_02: '../assets/models/SM_Bld_OfficeOld_Small_02.fbx',
    office_round: '../assets/models/SM_Bld_OfficeRound_01.fbx',
    office_square: '../assets/models/SM_Bld_OfficeSquare_01.fbx',
    shop: '../assets/models/SM_Bld_Shop_01.fbx',
    shop_corner: '../assets/models/SM_Bld_Shop_Corner_01.fbx',
    shop_with_roof: '../assets/models/Shop_cover.fbx',
    station: '../assets/models/SM_Bld_Station_03.fbx',
}

const environments = {
    cloud_01: '../assets/models/SM_Env_Cloud_01.fbx',
    cloud_02: '../assets/models/SM_Env_Cloud_02.fbx',
    cloud_03: '../assets/models/SM_Env_Cloud_03.fbx',
    flower: '../assets/models/SM_Env_Flower_01.fbx',
    road_arrow_forward: '../assets/models/SM_Env_Road_Arrow_01.fbx',//scale 0.05, dim : 25x25
    road_arrow_turn: '../assets/models/SM_Env_Road_Arrow_02.fbx',//scale 0.05, dim : 25x25
    road_bare: '../assets/models/SM_Env_Road_Bare_01.fbx',//scale 0.05, dim : 25x25
    road_crossing: '../assets/models/SM_Env_Road_Crossing_01.fbx',//scale 0.05, dim : 25x25
    road_line: '../assets/models/SM_Env_Road_Lines_01.fbx', //scale 0.05, dim : 25x25
    tree_01: '../assets/models/SM_Env_Tree_01.fbx',
    tree_02: '../assets/models/SM_Env_Tree_02.fbx',
    tree_03: '../assets/models/SM_Env_Tree_03.fbx',
}

const props = {
    cone: '../assets/models/SM_Prop_Cone_01.fbx',
    hotdog_stand: '../assets/models/SM_Prop_HotdogStand_01.fbx',
    hydrant: '../assets/models/SM_Prop_Hydrant_01.fbx',
    burger: '../assets/models/SM_Prop_LargeSign_Burger_01.fbx',
    hotdog: '../assets/models/SM_Prop_LargeSign_Hotdog_01.fbx',
    icecream: '../assets/models/SM_Prop_LargeSign_Icecream_01.fbx',
    pizza: '../assets/models/SM_Prop_LargeSign_Pizza_01.fbx',
    soda: '../assets/models/SM_Prop_LargeSign_Soda_01.fbx',
    taco: '../assets/models/SM_Prop_LargeSign_Taco_01.fbx',
    mailbox: '../assets/models/SM_Prop_Mailbox_01.fbx',
    bench: '../assets/models/SM_Prop_ParkBench_01.fbx',
    sign_stop: '../assets/models/SM_Prop_Sign_Stop_01.fbx',
    traffic_light: '../assets/models/SM_Prop_TrafficLight_01.fbx',
    water_tower: '../assets/models/SM_Prop_Water_Tower_01.fbx',
}

const baseMat = new THREE.MeshStandardMaterial({color: 0x7E7E7E});


export function build_city(scene, terrainDim) {
    /**
     * init terrain
     */
    let terrain = functions.createTerrain(terrainDim.width, terrainDim.height, baseMat,
        0, 0, 0);
    terrain.rotation.x += Math.radians(-90);
    scene.add(terrain);

    /**
     * light
     */
    scene.add(
        functions.createPointLight(2, 0xFFFFFF, 1, terrainDim.width / 4, 600, terrainDim.height / 4)
    );
    scene.add(new THREE.AmbientLight(0xffffff, 0.8))

    /**
     * Roads
     */
    build_roads(scene, terrainDim);
}

function build_roads(scene, terrainDim) {
    for (let j = 0; j <= terrainDim.width; j += 25) {
        for (let i = 0; i < terrainDim.height; i += 25) {
            if (j / 25 % 10 === 0) {
                if (i / 25 % 10 === 0 || i === terrainDim.height - 25) {
                    functions.loadStaticFBX(scene, environments.road_bare, "", 0.05, -terrainDim.width / 2 + j, 0.1, -terrainDim.height / 2 + 25 + i);
                } else {
                    functions.loadStaticFBX(scene, environments.road_line, "", 0.05, -terrainDim.width / 2 + j, 0.1, -terrainDim.height / 2 + 25 + i);
                }
            } else {
                if (i / 25 % 10 === 0 || i === terrainDim.height - 25) {
                    functions.loadStaticFBX(scene, environments.road_line, "", 0.05, -terrainDim.width / 2 + 25 + j, 0.1, -terrainDim.height / 2 + 25 + i, Math.radians(90));
                }
            }
        }
    }
}