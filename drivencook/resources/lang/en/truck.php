<?php

return [

    'new_truck' => 'New truck',
    'trucks_list' => 'Trucks list',
    'truck_view' => 'Truck view',
    'truck_info' => 'Truck information',
    'brand' => 'Brand',
    'model' => 'Model',
    'functional' => 'Functional',
    'purchase_date' => 'Purchase date',
    'license_plate' => 'License plate',
    'insurance_number' => 'Insurance number',
    'registration_document' => 'Registration document',
    'mileage' => 'Mileage',
    'fuel_type' => 'Fuel type',
    'chassis_number' => 'Chassis number',
    'engine_number' => 'Engine number',
    'horsepower' => 'Horsepower',
    'weight_empty' => 'Weight empty',
    'payload' => 'Payload',
    'general_state' => 'General state',
    'availability' => 'Availability',
    'available' => 'Available',
    'unavailable' => 'Unavailable: used by :franchisee',
    'location' => 'Location',
    'location_name' => 'Location name',
    'location_date_start' => 'Location date start',
    'location_date_end' => 'Location date end',
    'latest_safety_inspection' => 'Latest safety inspection',
    'truck_deployment' => 'Truck deployment',
    'available_franchisees' => 'Available franchisees',
    'all_franchisees_unavailable' => 'All franchisees already have a truck assigned',
    'assign' => 'Assign',
    'assigned_to' => 'Assigned to :franchisee',
    'remove_truck' => 'Remove the truck',
    'submit' => 'Add',
    'update_submit' => 'Update',
    'truck_update' => 'Truck update',
    'update_truck_success' => 'Truck information have been updated',

    // Errors
    'brand_error' => 'Brand invalid format',
    'model_error' => 'Model invalid format',
    'functional_error' => 'Functional invalid format',
    'purchase_date_error' => 'Purchase date invalid format',
    'license_plate_error' => 'License plate invalid format',
    'registration_document_error' => 'Registration document invalid format',
    'insurance_number_error' => 'Insurance number invalid format',
    'fuel_type_error' => 'Fuel type invalid format',
    'chassis_number_error' => 'Chassis number invalid format',
    'engine_number_error' => 'Engine number invalid format',
    'horsepower_error' => 'Horsepower invalid format',
    'weight_empty_error' => 'Weight empty invalid format',
    'payload_error' => 'Payload invalid format',
    'general_state_error' => 'General state invalid format',
    'location_name_error' => 'Location name invalid format',
    'location_date_start_error' => 'Location date start invalid format',
    'duplicate_entry_error' => 'Truck already in database',
    'date_timeline_error' => 'Purchase date in the future compare to the location start date',
    'no_truck_assigned' => 'You do not have an assigned truck, please contact a Drive\'N\'Cook manager',
    'breakdown_doesnt_exist' => 'Error, the breakdown does not exist!',
    'inspection_doesnt_exist' => 'Error, the inspection does not exist!',
    'wrong_fields_number' => 'Incorrect number of fields',
    'franchisee_must_be_validated' => 'The user must be a "confirmed" franchisee to have a truck.',
    'truck_assigned' => 'The truck has been assigned',
    'incorrect_id' => 'Error, ID is incorrect',
    'license_plate_duplicate' => 'This license plate is already in the database',
    'registration_document_duplicate' => 'This registration document is already in the database',
    'engine_number_duplicate' => 'This engine number is already in the database',
    'chassis_number_duplicate' => 'This chassis number is already in the database',
    'empty_fields' => 'Every field must be filled',

    'new_truck_success' => 'New truck added',
    'new_truck_error' => 'Error adding new truck',
    'confirm_delete' => 'Are you sure you want to delete this truck? All associated data will be deleted.',
    'delete_success' => 'The truck has been deleted',
    'breakdown_updated' => 'The breakdown has been updated',
    'breakdown_created' => 'The breakdown has been created',
    'inspection_updated' => 'The inspection has been updated',
    'inspection_created' => 'The inspection has been created',

    // Tooltips
    'set_brand' => 'Set brand',
    'set_model' => 'Set model',
    'set_license_plate' => 'Set licence plate',
    'set_registration_document' => 'Registration document',
    'set_insurance_number' => 'Insurance number',
    'set_chassis_number' => 'Chassis number',
    'set_engine_number' => 'Engine number',
    'set_horsepower' => 'Horsepower',
    'set_weight_empty' => 'Weight empty',
    'set_payload' => 'Payload',
    'set_general_state' => 'General state',
    'set_location_name' => 'Location name',

    // Breakdown
    'breakdowns' => 'Breakdowns',
    'add_breakdown' => 'Add a breakdown',
    'breakdown_date' => 'Date',
    'breakdown_cost' => 'Cost',
    'breakdown_status' => 'Status',
    'breakdown_type' => 'Type',
    'breakdown_description' => 'Description',
    'breakdown_type_Batterie' => 'Battery',
    'breakdown_type_Moteur' => 'Engine',
    'breakdown_type_Alternateur' => 'Alternator',
    'breakdown_type_Freins' => 'Brakes',
    'breakdown_type_Refroidissement' => 'Cooling',
    'breakdown_type_Autre' => 'Other',
    'breakdown_status_Signalée' => 'Notified',
    'breakdown_status_Réparation en cours' => 'Repair in progress',
    'breakdown_status_Réparée' => 'Repaired',
    'confirm_delete_breakdown' => 'Are you sure you want to delete this breakdown?',
    'breakdown_deleted' => 'The breakdown has been deleted',
    'new_breakdown' => 'New breakdown',
    'breakdown_update' => 'Breakdown update',

    // Safety inspection
    'safety_inspections' => 'Safety inspections',
    'add_safety_inspection' => 'Add a safety inspection',
    'safety_inspection_date' => 'Date',
    'replaced_parts' => 'Replaced parts',
    'drained_fluids' => 'Drained fluids',
    'truck_age' => 'Age',
    'truck_age_years' => ':years years',
    'confirm_delete_inspection' => 'Are you sure you want to delete this safety inspection?',
    'new_inspection' => 'New safety inspection',
    'inspection_update' => 'Safety inspection update',
    'inspection_deleted' => 'The safety inspection has been deleted',

    // Dropdown menu
    'select_menu_off' => 'Choose...',
    'fuel_type_b7' => 'B7',
    'fuel_type_b10' => 'B10',
    'fuel_type_xtl' => 'XTL',
    'fuel_type_e10' => 'E10',
    'fuel_type_e5' => 'E5',
    'fuel_type_e85' => 'E85',
    'fuel_type_lng' => 'LNG',
    'fuel_type_h2' => 'H2',
    'fuel_type_cng' => 'CNG',
    'fuel_type_lpg' => 'LPG',
    'fuel_type_electric' => 'Electric',

    'yes' => 'Yes',
    'no' => 'No',
    'unknown' => 'Unknown',
    'ajax_error' => 'An error occurred while deleting, please refresh the page',
    'not_specified_m' => 'Not specified',
    'not_specified_f' => 'Not specified',
];