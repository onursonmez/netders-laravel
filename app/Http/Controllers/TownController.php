<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Town;
use Lang;
use Cache;

class TownController extends Controller
{
    public function search(Request $request)
    {
        $collection = Town::select(['id', 'title AS name'])->where('city_id', $request->get('city_id'))->get();
        $collection->prepend(['name' => Lang::get('general.all'), 'id' => null]);
        return response()->json($collection);
    }
}
