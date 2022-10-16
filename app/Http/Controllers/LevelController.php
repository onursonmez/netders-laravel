<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Level;
use Lang;
use Cache;

class LevelController extends Controller
{
    public function search(Request $request)
    {
        $collection = Level::select(['id', 'title AS name'])->where('subject_id', $request->get('subject_id'))->get();                      
        $collection->prepend(['name' => Lang::get('general.all'), 'id' => null]);
        return response()->json($collection);
    }
}
