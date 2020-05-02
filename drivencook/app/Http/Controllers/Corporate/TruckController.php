<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Breakdown;
use App\Models\Location;
use App\Models\SafetyInspection;
use App\Models\Truck;
use App\Models\User;
use App\Traits\EnumValue;
use DateTime;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    use EnumValue;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

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

    public function truck_update($id)
    {
        $truck = Truck::find($id);
        if (empty($truck))
            return view('corporate.truck.truck_list');
        $truck = $truck->toArray();

        $fuels = $this->get_enum_column_values('truck', 'fuel_type');
        $locations = Location::all();
        if (!empty($locations)) {
            $locations = $locations->toArray();
        }
        return view('corporate.truck.truck_update')
            ->with('locations', $locations)
            ->with('truck', $truck)
            ->with('fuels', $fuels);
    }

    public function truck_update_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        $fuel_type_options = $this->get_enum_column_values('truck', 'fuel_type');
        var_dump($parameters);

        if (count($parameters) == 18) {
            $id = $parameters["id"];
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
            $location_id = $parameters["location_name"];
            $location_date_start = $parameters["location_date_start"];
            $location_date_end = $parameters["location_date_end"];

            if (!ctype_digit($id)) {
                $error = true;
                $errors_list[] = trans('truck_update.id_error');
            }
            if (strlen($brand) < 1 || strlen($brand) > 30) {
                $error = true;
                $errors_list[] = trans('truck_update.brand_error');
            }

            if (strlen($model) < 1 || strlen($model) > 30) {
                $error = true;
                $errors_list[] = trans('truck_update.model_error');
            }

            if ($functional != 0 && $functional != 1) {
                $error = true;
                $errors_list[] = trans('truck_update.functional_error');
            }

            $purchase_date_split = explode("-", $purchase_date);
            if (!checkdate($purchase_date_split[1], $purchase_date_split[2], $purchase_date_split[0])) {
                $error = true;
                $errors_list[] = trans('truck_update.purchase_date_error');
            }

            if (!preg_match('/^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/', $license_plate)) {
                $error = true;
                $errors_list[] = trans('truck_update.license_plate_error');
            }

            if (!preg_match('/^[A-Z0-9]{15}$/', $registration_document)) {
                $error = true;
                $errors_list[] = trans('truck_update.registration_document_error');
            }

            if (!preg_match('/^[A-Z0-9]{20}$/', $insurance_number)) {
                $error = true;
                $errors_list[] = trans('truck_update.insurance_number_error');
            }

            if (!in_array($fuel_type, $fuel_type_options)) {
                $error = true;
                $errors_list[] = trans('truck_update.fuel_type_error');
            }

            if (!preg_match('/^[0-9]{20}$/', $chassis_number)) {
                $error = true;
                $errors_list[] = trans('truck_update.chassis_number_error');
            }

            if (!preg_match('/^[0-9]{20}$/', $engine_number)) {
                $error = true;
                $errors_list[] = trans('truck_update.engine_number_error');
            }

            if ($horsepower < 1) {
                $error = true;
                $errors_list[] = trans('truck_update.horsepower_error');
            }

            if ($weight_empty < 1) {
                $error = true;
                $errors_list[] = trans('truck_update.weight_empty_error');
            }

            if ($payload < 2) {
                $error = true;
                $errors_list[] = trans('truck_update.payload_error');
            }

            if (strlen($general_state) < 1 || strlen($general_state) > 255) {
                $error = true;
                $errors_list[] = trans('truck_update.general_state_error');
            }

            if (!ctype_digit($location_id)) {
                $error = true;
                $errors_list[] = trans('truck_update.location_name_error');
            }

            $location_date_start_split = explode('-', $location_date_start);
            if (!checkdate($location_date_start_split[1], $location_date_start_split[2], $location_date_start_split[0])) {
                $error = true;
                $errors_list[] = trans('truck_update.location_date_start_error');
            }

            if ($location_date_end != null) {
                $location_date_end_split = explode('-', $location_date_end);
                if (!checkdate($location_date_end_split[1], $location_date_end_split[2], $location_date_end_split[0])) {
                    $error = true;
                    $errors_list[] = trans('truck_update.location_date_end_error');
                }
            }

            $date1 = new DateTime($purchase_date);
            $date2 = new DateTime($location_date_start);
            if ($date1 > $date2) {
                $error = true;
                $errors_list[] = trans('truck_update.date_timeline_error');
            }
            if ($location_date_end != null) {
                $date3 = new DateTime($location_date_end);
                if ($date2 > $date3) {
                    $error = true;
                    $errors_list[] = trans('truck_update.date_timeline_error');
                }
            }
        } else {
            $error = true;
            $errors_list[] = "Nombre de champs incorrect";
        }

        if ($error) {
            return redirect()->back()->with('error', $errors_list);
        }
        $truck = [
            'brand' => $brand, 'model' => $model, 'functional' => $functional,
            'purchase_date' => $purchase_date, 'license_plate' => $license_plate,
            'registration_document' => $registration_document, 'insurance_number' => $insurance_number,
            'fuel_type' => $fuel_type, 'chassis_number' => $chassis_number, 'engine_number' => $engine_number,
            'horsepower' => $horsepower, 'weight_empty' => $weight_empty,
            'payload' => $payload, 'general_state' => $general_state, 'location_id' => $location_id,
            'location_date_start' => $location_date_start, 'location_date_end' => $location_date_end
        ];
        Truck::find($id)->update($truck);
        return redirect()->route('truck_update', ['id' => $id])->with('success', trans('truck_update.update_truck_success'));
    }

    public function truck_list()
    {
        $trucks = Truck::with('user')
            ->with('location')
            ->with('last_safety_inspection')
            ->get()->toArray();
        return view('corporate.truck.truck_list')->with('trucks', $trucks);
    }

    public function truck_delete($id)
    {
        if (!ctype_digit($id)) {
            return 'error';
        }
        Breakdown::where('truck_id', $id)->delete();
        SafetyInspection::where('truck_id', $id)->delete();
        Truck::find($id)->delete();
        return $id;
    }

    public function truck_view($id)
    {
        $truck = Truck::whereKey($id)
            ->with('user')
            ->with('location')
            ->with('breakdowns')
            ->with('last_safety_inspection')
            ->with('safety_inspection')
            ->first()->toArray();

//        var_dump($truck);die;

        return view('corporate.truck.truck_view')->with("truck", $truck)->with("unassigned", $this->get_unassigned_truck_franchisees());
    }

    public function get_unassigned_truck_franchisees()
    {
        $assigned = Truck::select('user_id')->whereNotNull('user_id')->pluck('user_id')->toArray();
        $unassigned = User::select('id', 'firstname', 'lastname', 'pseudo_id')
            ->whereNotNull('pseudo_id')
            ->whereNotIn('id', $assigned)
            ->where("role", "Franchisé")
            ->with('pseudo')
            ->get()->toArray();

        return ($unassigned);
    }

    public function unset_franchise_truck($truck_id)
    {
        Truck::find($truck_id)->update(['user_id' => null]);
        return $truck_id;
    }

    public function set_franchise_truck()
    {
        request()->validate([
            'truckId' => ['required', 'integer'],
            'userId' => ['required', 'integer']
        ]);

        Truck::find(request('truckId'))->update([
            'user_id' => request('userId')
        ]);
        flash('Le camion a bien été assigné')->success();
        return back();
    }

    public function delete_breakdown($id)
    {
        Breakdown::find($id)->delete();
        return $id;
    }

    public function add_breakdown($truck_id)
    {
        if (Truck::find($truck_id) == null) {
            flash('Erreur, l\'id est incorrect !')->error();
            return back();
        }
        $breakdown_type = $this->get_enum_column_values('breakdown', 'type');
        $breakdown_status = $this->get_enum_column_values('breakdown', 'status');
        return view('corporate.truck.breakdown_form')
            ->with('breakdown_type', $breakdown_type)
            ->with('breakdown_status', $breakdown_status)
            ->with('truckId', $truck_id);
    }

    public function update_breakdown($truck_id, $breakdown_id)
    {
        $breakdown = Breakdown::find($breakdown_id);
        if (Truck::find($truck_id) == null || $breakdown == null) {
            flash('Erreur, l\'id est incorrect !')->error();
            return back();
        }
        $breakdown = $breakdown->toArray();
        $breakdown_type = $this->get_enum_column_values('breakdown', 'type');
        $breakdown_status = $this->get_enum_column_values('breakdown', 'status');


        return view('corporate.truck.breakdown_form')
            ->with('breakdown_type', $breakdown_type)
            ->with('breakdown_status', $breakdown_status)
            ->with('truckId', $truck_id)
            ->with('breakdown', $breakdown);
    }

    public function breakdown_submit()
    {
        request()->validate([
            'type' => ['required'],
            'cost' => ['required'],
            'date' => ['required', 'date'],
            'status' => ['required'],
            'truck_id' => ['required', 'integer']
        ]);

        if (!empty(request('id'))) {
            Breakdown::find(request('id'))->update
            ([
                'type' => request('type'),
                'description' => request('description'),
                'cost' => request('cost'),
                'date' => request('date'),
                'status' => request('status'),
                'truck_id' => request('truck_id'),
            ]);

            flash('Panne modifié')->success();
        } else {
            Breakdown::insert([
                'type' => request('type'),
                'description' => request('description'),
                'cost' => request('cost'),
                'date' => request('date'),
                'status' => request('status'),
                'truck_id' => request('truck_id'),
            ]);

            flash('Nouvelle panne ajouté')->success();
        }

        return redirect()->route('truck_view', ['id' => request('truck_id')]);
    }

    public function delete_safety_inspection($id)
    {
        SafetyInspection::find($id)->delete();
        return $id;
    }

    public function add_safety_inspection($truck_id)
    {
        if (Truck::find($truck_id) == null) {
            flash('Erreur, l\'id est incorrect !')->error();
            return back();
        }

        return view('corporate.truck.safety_inspection_form')
            ->with('truckId', $truck_id);
    }

    public function update_safety_inspection($truck_id, $safety_inspection_id)
    {
        $safety_inspection = SafetyInspection::find($safety_inspection_id);
        if (Truck::find($truck_id) == null || $safety_inspection == null) {
            flash('Erreur, l\'id est incorrect !')->error();
            return back();
        }
        $safety_inspection = $safety_inspection->toArray();
        return view('corporate.truck.safety_inspection_form')
            ->with('safety_inspection', $safety_inspection)
            ->with('truck_id', $truck_id);
    }

    public function safety_inspection_submit()
    {
        request()->validate([
            'date' => ['required', 'date'],
            'truck_age' => ['required', 'integer'],
            'truck_mileage' => ['required', 'integer'],
            'truck_id' => ['required', 'integer']
        ]);

        if (!empty(request('id'))) {
            SafetyInspection::find(request('id'))->update([
                'date' => request('date'),
                'truck_age' => request('truck_age'),
                'truck_mileage' => request('truck_mileage'),
                'replaced_parts' => request('replaced_parts'),
                'drained_fluids' => request('drained_fluids'),
                'truck_id' => request('truck_id')
            ]);

            flash('Contrôle technique mis à jour')->success();
        } else {
            SafetyInspection::insert([
                'date' => request('date'),
                'truck_age' => request('truck_age'),
                'truck_mileage' => request('truck_mileage'),
                'replaced_parts' => request('replaced_parts'),
                'drained_fluids' => request('drained_fluids'),
                'truck_id' => request('truck_id')
            ]);

            flash('Contrôle technique ajouté')->success();
        }
        return redirect()->route('truck_view', ['id' => request('truck_id')]);
    }
}
