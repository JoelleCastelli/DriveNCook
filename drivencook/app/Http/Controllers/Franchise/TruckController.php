<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Models\Breakdown;
use App\Models\Location;
use App\Models\Truck;
use App\Traits\EnumValue;
use App\Traits\UserTools;

class TruckController extends Controller
{
    use UserTools;
    use EnumValue;

    public function __construct()
    {
        $this->middleware(AuthFranchise::class);
    }

    private function check_truck_assignation(): bool
    {
        if (!$this->does_have_assigned_truck($this->get_connected_user()['id'])) {
            flash("Vous n'avez pas de camion attribué, veuillez contacter un responsable Drive N Cook")->warning();
            return false;
        }
        return true;
    }

    public function truck_view()
    {
        if (!$this->check_truck_assignation())
            return redirect(route('franchise.dashboard'));

        return view('franchise.truck.truck_view')
            ->with('franchise', $this->get_connected_user())
            ->with('truck', $this->get_franchises_truck());
    }

    private function get_franchises_truck()
    {
        return Truck::with('location')
            ->with('breakdowns')
            ->with('safety_inspection')
            ->where('user_id', $this->get_connected_user())
            ->first()->toArray();
    }

    private function get_locations_list()
    {
        return Location::with('city')->get()->toArray();
    }

    public function update_location()
    {
        if (!$this->check_truck_assignation())
            return redirect(route('franchise.dashboard'));

        return view('franchise.truck.truck_location_update')
            ->with('franchise', $this->get_connected_user())
            ->with('truck', $this->get_franchises_truck())
            ->with('location_list', $this->get_locations_list());
    }

    public function update_location_submit()
    {
        request()->validate([
            'location_id' => ['nullable', 'integer'],
            'location_date_start' => ['required', 'date'],
            'location_date_end' => ['nullable', 'date', 'after:location_date_start']
        ]);

        Truck::find($this->get_franchises_truck()['id'])->update([
            'location_id' => request('location_id'),
            'location_date_start' => request('location_date_start'),
            'location_date_end' => request('location_date_end')
        ]);
        flash('Position mis à jour')->success();
        return redirect(route('franchise.truck_view'));
    }

    public function add_breakdown()
    {
        if (!$this->check_truck_assignation())
            return redirect(route('franchise.dashboard'));

        $breakdown_type = $this->get_enum_column_values('breakdown', 'type');
        $breakdown_status = $this->get_enum_column_values('breakdown', 'status');


        return view('franchise.truck.breakdown_form')
            ->with('franchise', $this->get_connected_user())
            ->with('breakdown_type', $breakdown_type)
            ->with('breakdown_status', $breakdown_status);
    }

    public function update_breakdown($breakdown_id)
    {
        if (!$this->check_truck_assignation())
            return redirect(route('franchise.dashboard'));

        $breakdown = Breakdown::find($breakdown_id);
        if ($breakdown == null) {
            flash('Erreur, la pane n\'existe pas !')->error();
            return back();
        }
        $breakdown = $breakdown->toArray();

        $breakdown_type = $this->get_enum_column_values('breakdown', 'type');
        $breakdown_status = $this->get_enum_column_values('breakdown', 'status');


        return view('franchise.truck.breakdown_form')
            ->with('franchise', $this->get_connected_user())
            ->with('breakdown_type', $breakdown_type)
            ->with('breakdown_status', $breakdown_status)
            ->with('breakdown', $breakdown);
    }


    public function breakdown_submit()
    {
        request()->validate([
            'type' => ['required'],
            'cost' => ['required'],
            'date' => ['required', 'date'],
            'status' => ['required'],
        ]);

        if (!empty(request('id'))) {
            Breakdown::find(request('id'))->update
            ([
                'type' => request('type'),
                'description' => request('description'),
                'cost' => request('cost'),
                'date' => request('date'),
                'status' => request('status'),
            ]);

            flash('Panne modifié')->success();
        } else {
            Breakdown::insert([
                'type' => request('type'),
                'description' => request('description'),
                'cost' => request('cost'),
                'date' => request('date'),
                'status' => request('status'),
                'truck_id' => $this->get_franchises_truck()['id'],
            ]);

            flash('Nouvelle panne ajouté')->success();
        }

        return redirect(route('franchise.truck_view'));

    }

}