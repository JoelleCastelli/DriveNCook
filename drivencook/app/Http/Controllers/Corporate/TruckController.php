<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function truck_creation() {
        return view('corporate/truck/truck_creation');
    }

    public function get_truck($license_plate, $registration_document, $insurance_number, $chassis_number, $engine_number) {
        return Truck::where('license_plate', $license_plate)
            ->orWhere('registration_document', $registration_document)
            ->orWhere('insurance_number', $insurance_number)
            ->orWhere('chassis_number', $chassis_number)
            ->orWhere('engine_number', $engine_number)
            ->get();
    }

    public function truck_creation_submit(Request $request) {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        $fuel_type_options = ['B7', 'B10', 'XTL', 'E10', 'E5', 'E85', 'LNG', 'H2', 'CNG', 'LPG', 'Electric'];

        if (
            count($parameters) == 16 && !empty($parameters["brand"]) && !empty($parameters["model"]) && !empty($parameters["functional"]) &&
            !empty($parameters["purchase_date"]) && !empty($parameters["license_plate"]) && !empty($parameters["registration_document"]) &&
            !empty($parameters["insurance_number"]) && !empty($parameters["fuel_type"]) && !empty($parameters["chassis_number"]) &&
            !empty($parameters["engine_number"]) && !empty($parameters["horsepower"]) && !empty($parameters["weight_empty"]) &&
            !empty($parameters["payload"]) && !empty($parameters["general_state"]) && !empty($parameters["location_name"]) &&
            !empty($parameters["location_date_start"])
        ) {
            $brand = strtoupper($parameters["brand"]);
            $model = strtoupper($parameters["model"]);
            $functional = $parameters["functional"];
            $purchase_date = $parameters["purchase_date"];
            $license_plate = $parameters["license_plate"];
            $registration_document = $parameters["registration_document"];
            $insurance_number = $parameters["insurance_number"];
            $fuel_type = $parameters["fuel_type"];
            $chassis_number = $parameters["chassis_number"];
            $engine_number = $parameters["engine_number"];
            $horsepower = $parameters["horsepower"];
            $weight_empty = $parameters["weight_empty"];
            $payload = $parameters["payload"];
            $general_state = $parameters["general_state"];
            $location_name = $parameters["location_name"];
            $location_date_start = $parameters["location_date_start"];

            if (strlen($brand) < 1 || strlen($brand) > 30) {
                $error = true;
                $errors_list[] = trans('truck_creation.brand_error');
            }

            if (strlen($model) < 1 || strlen($model) > 30) {
                $error = true;
                $errors_list[] = trans('truck_creation.model_error');
            }

            if ($functional === 'on' || $functional === 'off') {
                $error = true;
                $errors_list[] = trans('truck_creation.functional_error');
            }

            $date_split = explode("-", $purchase_date);

            if (!checkdate($date_split[2], $date_split[1], $date_split[0])) {
                $error = true;
                $errors_list[] = trans('truck_creation.purchase_date_error');
            }

            if(!preg_match('/^(A-Z){2}-(0-9){3}-(A-Z){2}$/', $license_plate)) {
                $error = true;
                $errors_list[] = trans('truck_creation.license_plate_error');
            }

            if(!preg_match('/^(A-Z0-9){15}$/', $registration_document)) {
                $error = true;
                $errors_list[] = trans('truck_creation.registration_document_error');
            }

            if(!preg_match('/^(A-Z0-9){20}$/', $insurance_number)) {
                $error = true;
                $errors_list[] = trans('truck_creation.insurance_number_error');
            }

            if(!in_array($fuel_type, $fuel_type_options)) {
                $error = true;
                $errors_list[] = trans('truck_creation.fuel_type_error');
            }

            if(!preg_match('/^(0-9){20}$/', $chassis_number)) {
                $error = true;
                $errors_list[] = trans('truck_creation.chassis_number_error');
            }

            if(!preg_match('/^(0-9){20}$/', $engine_number)) {
                $error = true;
                $errors_list[] = trans('truck_creation.engine_number_error');
            }

            if($horsepower > 1) {
                $error = true;
                $errors_list[] = trans('truck_creation.horsepower_error');
            }

            if($weight_empty > 1) {
                $error = true;
                $errors_list[] = trans('truck_creation.weight_empty_error');
            }

            if($payload > 2) {
                $error = true;
                $errors_list[] = trans('truck_creation.payload_error');
            }

            if($general_state > 0 && $general_state < 256) {
                $error = true;
                $errors_list[] = trans('truck_creation.general_state_error');
            }

            if(!preg_match('/^(A-Za-z)+$/', $location_name)) {
                $error = true;
                $errors_list[] = trans('truck_creation.location_name_error');
            }

            if (!checkdate($date_split[2], $date_split[1], $date_split[0])) {
                $error = true;
                $errors_list[] = trans('truck_creation.location_date_start_error');
            }

            if (!$error) {
                $result = $this->get_truck($license_plate, $registration_document, $insurance_number, $chassis_number, $engine_number);
                if (!empty($result)) {
                    $error = true;
                    $errors_list[] = trans('truck_creation.duplicate_entry_error');
                }
            }

            //htmlspecialchars() expects parameter 1 to be string, array given (
            //View: E:\Travail\Ecole\ESGI\Projet Annuel\DriveNCook\drivencook\resources\views\corporate\truck\truck_creation.blade.php
            //)
            die;

            if($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $truck = [$brand, $model, $functional, $purchase_date, $license_plate, $registration_document,
                    $insurance_number, $fuel_type, $chassis_number, $engine_number, $horsepower, $weight_empty,
                    $payload, $general_state, $location_name, $location_date_start
                ];
                Truck::create($truck);
                return redirect()->route('truck_creation')->with('success', trans('truck_creation.new_truck_success'));
            }
        }
    }
}