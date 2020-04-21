<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Truck;
use App\Traits\EnumValue;
use DateTime;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    use EnumValue;

    public function truck_creation()
    {
        $fuels = $this->get_enum_column_values('truck', 'fuel_type');
        $locations = Location::select('name', 'address')->get();
        if (!empty($locations)) {
            $locations = $locations->toArray();
        }
        return view('corporate/truck/truck_creation')->with('locations', $locations)->with('fuels', $fuels);
    }

    public function get_truck($license_plate, $registration_document, $insurance_number, $chassis_number, $engine_number)
    {
        return Truck::where('license_plate', $license_plate)
            ->orWhere('registration_document', $registration_document)
            ->orWhere('insurance_number', $insurance_number)
            ->orWhere('chassis_number', $chassis_number)
            ->orWhere('engine_number', $engine_number)
            ->get();
    }

    public function get_location_id_by_name($location_name)
    {
        return $location = Location::where('name', $location_name)->first()->id;
    }

    public function truck_creation_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        $fuel_type_options = $this->get_enum_column_values('truck', 'fuel_type');

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
            $license_plate = strtoupper($parameters["license_plate"]);
            $registration_document = strtoupper($parameters["registration_document"]);
            $insurance_number = strtoupper($parameters["insurance_number"]);
            $fuel_type = $parameters["fuel_type"];
            $chassis_number = $parameters["chassis_number"];
            $engine_number = $parameters["engine_number"];
            $horsepower = $parameters["horsepower"];
            $weight_empty = $parameters["weight_empty"];
            $payload = $parameters["payload"];
            $general_state = $parameters["general_state"];
            $location_name = $parameters["location_name"];
            $location_id = -1;
            $location_date_start = $parameters["location_date_start"];

            if (strlen($brand) < 1 || strlen($brand) > 30) {
                $error = true;
                $errors_list[] = trans('truck_creation.brand_error');
            }

            if (strlen($model) < 1 || strlen($model) > 30) {
                $error = true;
                $errors_list[] = trans('truck_creation.model_error');
            }

            if (!($functional === 'on' || $functional === 'off')) {
                $error = true;
                $errors_list[] = trans('truck_creation.functional_error');
            } else {
                if ($functional === 'on') {
                    $functional = true;
                } else {
                    $functional = false;
                }
            }

            $purchase_date_split = explode("-", $purchase_date);
            if (!checkdate($purchase_date_split[1], $purchase_date_split[2], $purchase_date_split[0])) {
                $error = true;
                $errors_list[] = trans('truck_creation.purchase_date_error');
            }

            if (!preg_match('/^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/', $license_plate)) {
                $error = true;
                $errors_list[] = trans('truck_creation.license_plate_error');
            }

            if (!preg_match('/^[A-Z0-9]{15}$/', $registration_document)) {
                $error = true;
                $errors_list[] = trans('truck_creation.registration_document_error');
            }

            if (!preg_match('/^[A-Z0-9]{20}$/', $insurance_number)) {
                $error = true;
                $errors_list[] = trans('truck_creation.insurance_number_error');
            }

            if (!in_array($fuel_type, $fuel_type_options)) {
                $error = true;
                $errors_list[] = trans('truck_creation.fuel_type_error');
            }

            if (!preg_match('/^[0-9]{20}$/', $chassis_number)) {
                $error = true;
                $errors_list[] = trans('truck_creation.chassis_number_error');
            }

            if (!preg_match('/^[0-9]{20}$/', $engine_number)) {
                $error = true;
                $errors_list[] = trans('truck_creation.engine_number_error');
            }

            if ($horsepower < 1) {
                $error = true;
                $errors_list[] = trans('truck_creation.horsepower_error');
            }

            if ($weight_empty < 1) {
                $error = true;
                $errors_list[] = trans('truck_creation.weight_empty_error');
            }

            if ($payload < 2) {
                $error = true;
                $errors_list[] = trans('truck_creation.payload_error');
            }

            if (strlen($general_state) < 1 || strlen($general_state) > 255) {
                $error = true;
                $errors_list[] = trans('truck_creation.general_state_error');
            }

            if (!preg_match('/^[A-Za-z -_]+$/', $location_name)) {
                $error = true;
                $errors_list[] = trans('truck_creation.location_name_error');
            } else {
                $location_id = $this->get_location_id_by_name($location_name);
                if (empty($location_id)) {
                    $error = true;
                    $errors_list[] = trans('truck_creation.location_name_error');
                }
            }

            $location_date_start_split = explode('-', $location_date_start);
            if (!checkdate($location_date_start_split[1], $location_date_start_split[2], $location_date_start_split[0])) {
                $error = true;
                $errors_list[] = trans('truck_creation.location_date_start_error');
            }

            $date1 = new DateTime($purchase_date);
            $date2 = new DateTime($location_date_start);
            if ($date1 > $date2) {
                $error = true;
                $errors_list[] = trans('truck_creation.date_timeline_error');
            }

            if (!$error) {
                $result = $this->get_truck($license_plate, $registration_document, $insurance_number, $chassis_number, $engine_number);
                if (count($result) != 0) {
                    $error = true;
                    $errors_list[] = trans('truck_creation.duplicate_entry_error');
                }
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $truck = [
                    'brand' => $brand, 'model' => $model, 'functional' => $functional,
                    'purchase_date' => $purchase_date, 'license_plate' => $license_plate,
                    'registration_document' => $registration_document, 'insurance_number' => $insurance_number,
                    'fuel_type' => $fuel_type, 'chassis_number' => $chassis_number, 'engine_number' => $engine_number,
                    'horsepower' => $horsepower, 'weight_empty' => $weight_empty,
                    'payload' => $payload, 'general_state' => $general_state, 'location_id' => $location_id,
                    'location_date_start' => $location_date_start
                ];
                Truck::insert($truck);
                return redirect()->route('truck_creation')->with('success', trans('truck_creation.new_truck_success'));
            }
        } else {
            $errors_list[] = trans('truck_creation.empty_fields');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function truck_list()
    {
        $trucks = Truck::with('user')
            ->with('location')
            ->with('last_safety_inspection')
            ->get()->toArray();
        return view('corporate.truck.truck_list')->with('trucks', $trucks);
    }
}
