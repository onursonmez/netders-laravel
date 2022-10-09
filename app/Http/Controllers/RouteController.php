<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class RouteController extends Controller
{
    public function index($slug, Request $request)
    { 
        $category = \App\Models\Content_category::where('slug', $slug)->first();
        if(!empty($category))
        {
            $contentController = new ContentController;
            return $contentController->category($slug, $request);
        }

        $content = \App\Models\Content::where('slug', $slug)->first();
        if(!empty($content))
        {
            $contentController = new ContentController;
            return $contentController->detail($slug);
        }
        
        $username_old_is_exists = \App\Models\Username::where('username', $slug)->first();
        if(!empty($username_old_is_exists))
        {
            $user = \App\Models\User::find($username_old_is_exists->user_id);
            if(!empty($user))
            {
                return Redirect::to($user->username, 301);
            }
        }  
        
        $user = \App\Models\User::where('username', $slug)->first();
        if(!empty($user))
        {
            $userController = new UserController;
            return $userController->show($slug);
        }    

        $price = \App\Models\Price::where('slug', $slug)->first();
        if(!empty($price))
        {
            $priceController = new PriceController;
            return $priceController->detail($price->slug);
        }            
        
        return abort(404);
        
    }
}
