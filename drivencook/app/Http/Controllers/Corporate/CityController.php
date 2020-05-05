<?php


namespace App\Http\Controllers\Corporate;


use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Location;
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

        if (strlen($response['name']) > 15) {
            return 'error, wrong name size';
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

        if (strlen($response['name']) > 15) {
            return 'error, wrong name size';
        }
        Country::find($response['id'])->update(['name' => $response['name']]);
        $response['response'] = 'success';
        return json_encode($response);
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

    }

    public function city_add()
    {

    }

    public function city_edit()
    {

    }

    public function city_submit()
    {

    }

    public function city_delete()
    {

    }

}