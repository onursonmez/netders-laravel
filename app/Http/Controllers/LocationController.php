<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Lang;
use \App\Models\City;
use \App\Models\Town;
use \App\Models\Location;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $this->data['cities'] = City::get();
        $this->data['locations'] = Location::where('user_id', Auth::user()->id)->with('city')->with('town')->get();
        
        return view('locations.index', $this->data);
    }

    public function load_new(Request $request)
    {
        $items = Town::where('city_id', $request->get('selected_id'))->get();
                
        $returnHTML = view('locations.load_new')->with('items', $items)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);  
    }    

    public function load_exists($user_id)
    {
        $locations = Location::where('user_id', $user_id)->with('city')->with('town')->get();
        
        $returnHTML = view('locations.load_exists')->with('locations', $locations)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);  
    }    

    public function store(Request $request)
    {
        $request->validate([
            'city_id'           => 'required',
            'towns'             => 'required',
        ]);

        foreach($request->get('towns') as $town_id)
        {
            Location::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'city_id' => $request->get('city_id'),
                    'town_id' => $town_id
                ]
            );            
        }

        return $request->wantsJson()
                    ? response()->json(['call' => $request->get('call'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);          
    }
        

    public function delete(Request $request)
    {
        $location = Location::find($request->get('id'));

        if($location->user_id == Auth::user()->id)
        {
            $location->delete();
        }    

        return $request->wantsJson()
                    ? response()->json(['call' => $request->get('call'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);                  
    }        
}
