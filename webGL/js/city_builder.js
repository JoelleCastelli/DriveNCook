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
    apartment_01: '../assets/models/SM_Bld_Apartment_Stack_02.fbx', //scale 0.1, dim : 50x50
    apartment_02: '../assets/models/SM_Bld_Apartment_Stack_03.fbx',//scale 0.1, dim : 50x50
    office_octagon: '../assets/models/SM_Bld_OfficeOctagon_01.fbx', // scale 0.09, dim : 200x200
    office_old_large: '../assets/models/SM_Bld_OfficeOld_Large_01.fbx',
    office_old_small_01: '../assets/models/SM_Bld_OfficeOld_Small_01.fbx',// scale 0.06, dim : 60x60
    office_old_small_02: '../assets/models/SM_Bld_OfficeOld_Small_02.fbx',
    office_round: '../assets/models/SM_Bld_OfficeRound_01.fbx',// scale 0.03 dim : 60x60, y 70
    office_square: '../assets/models/SM_Bld_OfficeSquare_01.fbx',// scale 0.04 dim : 60x60 y 70
    shop: '../assets/models/SM_Bld_Shop_01.fbx',//scale 0.1, dim : 50x50
    shop_corner: '../assets/models/SM_Bld_Shop_Corner_01.fbx',//scale 0.1, dim : 50x50
    shop_with_roof: '../assets/models/Shop_cover.fbx',
    station: '../assets/models/SM_Bld_Station_03.fbx',// scale 0.8
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
        functions.createPointLight(2, 0xFFFFFF, 1.2, terrainDim.width / 4, 400, terrainDim.height / 4)
    );
    scene.add(new THREE.AmbientLight(0xffffff, 1))

    /**
     * Roads
     */
    build_roads(scene, terrainDim);

    /**
     * Buildings
     */
    add_buildings(scene, terrainDim);
}

function build_roads(scene, terrainDim) {
    for (let j = 0; j <= terrainDim.width; j += 25) {
        for (let i = 0; i <= terrainDim.height; i += 25) {
            if (j / 25 % 10 === 0) {
                if (i / 25 % 10 === 0 || i === terrainDim.height) {
                    functions.loadStaticFBX(scene, environments.road_bare, "", 0.05, -terrainDim.width / 2 + j, 0.1, -terrainDim.height / 2 + 25 + i);
                } else {
                    functions.loadStaticFBX(scene, environments.road_line, "", 0.05, -terrainDim.width / 2 + j, 0.1, -terrainDim.height / 2 + 25 + i);
                }
            } else {
                if (i / 25 % 10 === 0 || i === terrainDim.height) {
                    functions.loadStaticFBX(scene, environments.road_line, "", 0.05, -terrainDim.width / 2 + 25 + j, 0.1, -terrainDim.height / 2 + 25 + i, Math.radians(90));
                }
            }
        }
    }
}

function add_buildings(scene, terrainDim) {
    let xStart = 0;
    let zStart = 0;
    // Line 1
    fill_square_building_1(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_2(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_3(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_4(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);

    // Line 2
    xStart = 0;
    zStart += 250;
    fill_square_building_4(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_1(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_3(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_2(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);

    // Line 3
    xStart = 0;
    zStart += 250;
    fill_square_building_2(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_1(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_2(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_4(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);

    // Line 4
    xStart = 0;
    zStart += 250;
    fill_square_building_3(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_4(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_1(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
    xStart += 250;
    fill_square_building_2(scene, -terrainDim.width / 2 + 25 + xStart, -terrainDim.height / 2 + 25 + zStart);
}

function fill_square_building_1(scene, xStart, zStart) {
    let x = xStart + 5;
    let z = zStart + 5;
    functions.loadStaticFBX(scene, buildings.apartment_01, "", 0.1, x, 0, z, Math.radians(-90));
    z += 55;
    functions.loadStaticFBX(scene, buildings.apartment_01, "", 0.1, x, 0, z, Math.radians(-90));
    z += 55;
    functions.loadStaticFBX(scene, buildings.apartment_02, "", 0.1, x, 0, z, Math.radians(-90));
    z += 55 + 50;
    functions.loadStaticFBX(scene, buildings.shop_corner, "", 0.1, x, 0, z);
    x += 105;
    z -= 20;
    functions.loadStaticFBX(scene, buildings.station, "", 0.08, x, 0, z);
    functions.loadStaticFBX(scene, props.water_tower, "", 0.2, x, 0, z - 75);

    x += 60;
    functions.loadStaticFBX(scene, props.bench, "", 0.1, x, 0, z);
    x += 25;
    functions.loadStaticFBX(scene, props.bench, "", 0.1, x, 0, z);
    x += 20;
    functions.loadStaticFBX(scene, props.mailbox, "", 0.1, x, 0, z);
    z -= 30;
    functions.loadStaticFBX(scene, buildings.office_old_small_01, "", 0.06, x, 0, z, Math.radians(90));
    z -= 90;
    functions.loadStaticFBX(scene, buildings.office_old_small_01, "", 0.06, x, 0, z, Math.radians(90));
    x -= 90;
    z -= 60;
    functions.loadStaticFBX(scene, buildings.shop, "", 0.06, x, 0, z, Math.radians(180));


}

function fill_square_building_2(scene, xStart, zStart) {
    let x = xStart;
    let z = zStart;
    functions.loadStaticFBX(scene, buildings.office_octagon, "", 0.09, x + 110, 90, z + 110);
    x += 20;
    z += 20;
    functions.loadStaticFBX(scene, environments.tree_02, "", 0.1, x, 0, z);
    x += 180;
    functions.loadStaticFBX(scene, environments.tree_02, "", 0.1, x, 0, z);
    z += 180;
    functions.loadStaticFBX(scene, environments.tree_02, "", 0.1, x, 0, z);
    x -= 180;
    functions.loadStaticFBX(scene, environments.tree_02, "", 0.1, x, 0, z);

}

function fill_square_building_3(scene, xStart, zStart) {
    let x = xStart + 40;
    let z = zStart + 40;
    functions.loadStaticFBX(scene, buildings.office_round, "", 0.03, x, 70, z);
    z += 75;
    functions.loadStaticFBX(scene, buildings.office_square, "", 0.04, x, 70, z);
    z += 75;
    functions.loadStaticFBX(scene, buildings.office_square, "", 0.04, x, 70, z);
    x += 75;
    functions.loadStaticFBX(scene, buildings.shop_with_roof, "", 0.1, x, 15, z);
    functions.loadStaticFBX(scene, props.water_tower, "", 0.2, x, 0, z - 75);
    x += 40;
    functions.loadStaticFBX(scene, props.bench, "", 0.1, x, 0, z);
    functions.loadStaticFBX(scene, environments.flower, "", 0.1, x - 10, 0, z + 15);
    functions.loadStaticFBX(scene, environments.flower, "", 0.1, x - 5, 0, z + 10);
    functions.loadStaticFBX(scene, environments.flower, "", 0.1, x + 2, 0, z + 11);
    functions.loadStaticFBX(scene, environments.flower, "", 0.1, x + 10, 0, z + 13);
    x += 20
    functions.loadStaticFBX(scene, props.hydrant, "", 0.1, x, 0, z);
    x += 30
    functions.loadStaticFBX(scene, vehicles.car_muscle, "", 0.08, x, 0, z);
    x += 10
    z -= 100
    functions.loadStaticFBX(scene, buildings.office_old_small_01, "", 0.06, x, 0, z, Math.radians(180));
    z -= 60;
    x -= 70;
    functions.loadStaticFBX(scene, buildings.station, "", 0.08, x, 0, z, Math.radians(180));
}

function fill_square_building_4(scene, xStart, zStart) {
    let x = xStart;
    let z = zStart;
    functions.loadStaticFBX(scene, buildings.office_old_large, "", 0.09, x + 40, 0, z + 180);
    x += 20;
    z += 20;
    functions.loadStaticFBX(scene, environments.tree_01, "", 0.1, x, 0, z);
    x += 180;
    functions.loadStaticFBX(scene, environments.tree_01, "", 0.1, x, 0, z);
    z += 180;
    functions.loadStaticFBX(scene, environments.tree_01, "", 0.1, x, 0, z);
    x -= 180;
    functions.loadStaticFBX(scene, environments.tree_01, "", 0.1, x, 0, z);
}
