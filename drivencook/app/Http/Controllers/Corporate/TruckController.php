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

        if (
            count($parameters) == 16 && !empty($parameters["brand"]) && !empty($parameters["model"]) && !empty($parameters["functional"]) &&
            !empty($parameters["purchase_date"]) && !empty($parameters["license_date"]) && !empty($parameters["registration_document"]) &&
            !empty($parameters["insurance_number"]) && !empty($parameters["fuel_type"]) && !empty($parameters["chassis_number"]) &&
            !empty($parameters["engine_number"]) && !empty($parameters["horsepower"]) && !empty($parameters["weight_empty"]) &&
            !empty($parameters["payload"]) && !empty($parameters["general_state"]) && !empty($parameters["location_name"]) &&
            !empty($parameters["location_date_start"])
        ) {
            $brand = strtoupper($parameters["brand"]);
            $model = strtoupper($parameters["model"]);
            $functional = $parameters["functional"];
            $purchase_date = $parameters["purchase_date"];
            $license_date = $parameters["license_date"];
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

            $purchase_date_arr = explode("-", $purchase_date);
            //checkdate($purchase_date_arr[2], $purchase_date_arr[1], $purchase_date_arr[0]);

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

            if (strlen($model) < 1 || strlen($model) > 30) {
                $error = true;
                $errors_list[] = trans('truck_creation.model_error');
            }

            /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $errors_list[] = trans('franchisee_creation.email_format_error');
            } else if (!$error) {
                $result = $this->get_truck($license_plate, $registration_document, $insurance_number, $chassis_number, $engine_number);
                if (!empty($result)) {
                    $error = true;
                    $errors_list[] = trans('franchisee_creation.email_error');
                }
            }*/

            if($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $truck = [$brand, $model, $functional, $purchase_date, $license_date, $registration_document,
                    $insurance_number, $fuel_type, $chassis_number, $engine_number, $horsepower, $weight_empty,
                    $payload, $general_state, $location_name, $location_date_start
                ];
                Truck::create($truck);
                return redirect()->route('truck_creation')->with('success', trans('truck_creation.new_truck_success'));
            }
        }

        var_dump($parameters); die;
    }
}