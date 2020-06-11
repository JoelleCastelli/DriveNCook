<?php


namespace App\Http\Controllers\Corporate;


use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Location;
use App\Models\Truck;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function country_list()
    {
        $country_list = Country::all()->toArray();
//        var_dump($country_list);die;
        return view('corporate.city_country.country_list')->with('country_list', $country_list);
    }

    public function country_add($parameters)
    {
        $response = [];
        $response['isNew'] = true;
        $response['name'] = strtoupper(trim($parameters['name']));

        if (strlen($check = $this->check_country_form($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }
        $response['id'] = Country::insertGetId(['name' => $response['name']]);
        $response['response'] = 'success';
        return json_encode($response);
    }

    public function country_edit($parameters)
    {
        $response = [];
        $response['isNew'] = false;
        $response['id'] = $parameters['id'];
        $response['name'] = strtoupper(trim($parameters['name']));

        if (strlen($check = $this->check_country_form($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }
        Country::find($response['id'])->update(['name' => $response['name']]);
        $response['response'] = 'success';
        return json_encode($response);
    }

    public function check_country_form($response): string
    {
        if (empty($response['name']) || strlen($response['name']) > 15) {
            return 'error, wrong name size';
        }
        return '';
    }

    public function country_delete($id)
    {
        $city_list = City::where('country_id', $id)->get(['id'])->toArray();
        Warehouse::whereIn('city_id', $city_list)->update(['city_id' => null]);
        Location::whereIn('city_id', $city_list)->update(['city_id' => null]);
        City::where('country_id', $id)->delete();
        Country::find($id)->delete();
        return $id;
    }

    public function country_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        if (empty($parameters['id']))
            return $this->country_add($parameters);
        return $this->country_edit($parameters);
    }

    public function city_list($country_id)
    {
        $country = Country::find($country_id)->toArray();
        $city_list = City::where('country_id', $country_id)->get()->toArray();
        return view('corporate.city_country.city_list')
            ->with('country', $country)
            ->with('city_list', $city_list);
    }

    public function city_add($parameters)
    {
        $response = [];
        $response['isNew'] = true;
        $response['name'] = strtoupper(trim($parameters['name']));
        $response['postcode'] = trim($parameters['postcode']);
        $response['country_id'] = trim($parameters['country_id']);

        if (strlen($check = $this->check_city_form($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }

        $response['id'] = City::insertGetId([
            'name' => $response['name'],
            'postcode' => $response['postcode'],
            'country_id' => $response['country_id']
        ]);
        $response['response'] = 'success';
        return json_encode($response);
    }

    public function city_edit($parameters)
    {
        $response = [];
        $response['isNew'] = false;
        $response['id'] = $parameters['id'];
        $response['name'] = strtoupper(trim($parameters['name']));
        $response['postcode'] = trim($parameters['postcode']);
        $response['country_id'] = trim($parameters['country_id']);

        if (strlen($check = $this->check_city_form($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }

        City::find($response['id'])->update([
            'name' => $response['name'],
            'postcode' => $response['postcode'],
            'country_id' => $response['country_id']
        ]);
        $response['response'] = 'success';
        return json_encode($response);
    }


    public function check_city_form($response): string
    {
        if (empty($response['name']) || strlen($response['name']) > 15) {
            return 'error, wrong name size';
        }
        if (empty($response['postcode']) || !ctype_digit($response['postcode'])) {
            return 'error, wrong postcode';
        }
        if (empty($response['country_id']) || !ctype_digit($response['country_id'])) {
            return 'error, wrong country_id';
        }
        return '';
    }

    public function city_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        if (empty($parameters['id']))
            return $this->city_add($parameters);
        return $this->city_edit($parameters);
    }

    public function city_delete($id)
    {
        Warehouse::where('city_id', $id)->update(['city_id' => null]);
        Location::where('city_id', $id)->update(['city_id' => null]);
        City::find($id)->delete();
        return $id;
    }

    public function location_add($parameters) {
        $response = [];
        $response['isNew'] = true;
        $response['name'] = ucfirst(trim($parameters['name']));
        $response['address'] = trim($parameters['address']);
        $response['city'] = ucfirst(trim($parameters['city']));
        $response['postcode'] = trim($parameters['postcode']);
        $response['country'] = ucfirst(trim($parameters['country']));
        $response['latitude'] = trim($parameters['lat']);
        $response['longitude'] = trim($parameters['lon']);

        if (strlen($check = $this->check_location_form($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }
        if (strlen($check = $this->get_location_by_address($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }
        if (strlen($check = $this->get_location_by_name($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }

        $response['id'] = Location::insertGetId([
            'name' => $response['name'],
            'address' => $response['address'],
            'city' => $response['city'],
            'postcode' => $response['postcode'],
            'country' => $response['country'],
            'latitude' => $response['latitude'],
            'longitude' => $response['longitude']
        ]);
        $response['response'] = 'success';
        return json_encode($response);
    }

    public function get_location_by_address($response) {
        $duplicate = Location::where('address', $response['address'])
            ->where('city', $response['city'])
            ->where('postcode', $response['postcode'])
            ->where('country', $response['country'])
            ->first();

        if(!empty($duplicate)) {
            return "This address is already in the database";
        } else {
            return '';
        }
    }

    public function get_location_by_lat_lon($response) {
        $duplicate = Location::where([
            ['latitude', $response['latitude']],
            ['longitude', $response['longitude']]
        ])->first();

        if (!empty($duplicate)) {
            return "This address is already in the database";
        } else {
            return '';
        }
    }

    public function get_location_by_name($response) {
        $duplicate = Location::where('name', $response['name'])->first();
        if(!empty($duplicate)) {
            return "This name is already in the database";
        } else {
            return '';
        }
    }

    public function location_edit($parameters)
    {
        $response = [];
        $response['isNew'] = false;
        $response['id'] = trim($parameters['id']);
        $response['name'] = ucfirst(trim($parameters['name']));
        $response['address'] = trim($parameters['address']);
        $response['city'] = ucfirst(trim($parameters['city']));
        $response['postcode'] = trim($parameters['postcode']);
        $response['country'] = ucfirst(trim($parameters['country']));
        $response['latitude'] = trim($parameters['lat']);
        $response['longitude'] = trim($parameters['lon']);

        if (strlen($check = $this->check_location_form($response)) > 0) {
            return response($check, 400)->header('Content-Type', 'text/plain');
        }

        $current_values = Location::where('id', $response['id'])->first()->toArray();
        // If the name changed, we check that it's not already in the DB
        if($current_values['name'] != $response['name']) {
            if (strlen($check = $this->get_location_by_name($response)) > 0) {
                return response($check, 400)->header('Content-Type', 'text/plain');
            }
        }

        // If the address changed, we check that it's not already in the DB
        if($current_values['latitude'] != $response['latitude'] || $current_values['longitude'] != $response['longitude']) {
            if (strlen($check = $this->get_location_by_lat_lon($response)) > 0) {
                return response($check, 400)->header('Content-Type', 'text/plain');
            }
        }

        Location::find($response['id'])->update([
            'name' => $response['name'],
            'address' => $response['address'],
            'city' => $response['city'],
            'postcode' => $response['postcode'],
            'country' => $response['country'],
            'latitude' => $response['latitude'],
            'longitude' => $response['longitude'],
        ]);
        $response['response'] = 'success';
        return json_encode($response);
    }

    public function check_location_form($response): string
    {
        if (empty($response['name'])) {
            return 'Error, please enter a name';
        }
        if (empty($response['address']) || empty($response['city']) || empty($response['postcode']) || empty($response['country']) ) {
            return 'Error, please enter an address';
        }

        if (strlen($response['name']) > 30) {
            return 'Error, incorrect name size';
        }
        if (strlen($response['address']) > 100) {
            return 'Error, incorrect address size';
        }
        if (strlen($response['city']) > 50) {
            return 'Error, incorrect city size';
        }
        if (strlen($response['postcode']) > 7) {
            return 'Error, incorrect postcode size';
        }
        if (strlen($response['country']) > 50) {
            return 'Error, incorrect country size';
        }

        return '';
    }

    public function location_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        if ($parameters['id'] == 0)
            return $this->location_add($parameters);
        return $this->location_edit($parameters);
    }

    public function location_list()
    {
        $city_list = City::with('country')->get()
            ->sortBy('country.name')
            ->sortBy('city.name')
            ->toArray();
        $location_list = Location::get()->toArray();

        return view('corporate.city_country.location_list')
            ->with('city_list', $city_list)
            ->with('location_list', $location_list);
    }

    public function location_delete($location_id)
    {
        Truck::where('location_id', $location_id)->update(['location_id' => null]);
        Location::find($location_id)->delete();
        return $location_id;
    }

}