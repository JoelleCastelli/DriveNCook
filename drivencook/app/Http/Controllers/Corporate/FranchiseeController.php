<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FranchiseeController extends Controller
{

    public function franchisee_creation(){
        return view('corporate/franchisee_creation');
    }

    public function franchisee_creation_submit(Request $request){
        $parameters = $request->all();

        // add to database

        // Si tout va bien
        //return redirect()->route('franchisee_creation')->with('success', trans('franchisee_creation.new_franchisee_success'));

        // Sinon
        //return redirect()->back();
        return redirect()->route('franchisee_creation')->with('error', trans('franchisee_creation.new_franchisee_error'));
    }

    public function test(){
        return view('test');
    }
}