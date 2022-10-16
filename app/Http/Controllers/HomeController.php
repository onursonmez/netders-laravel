<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use Lang;
use Cache;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        $cache = md5(json_encode('users'));
        if(Cache::has($cache))
        {
            $data['users'] = Cache::get($cache);
        }
        else
        {
            $userController = new UserController;
            foreach(Lang::get('general.home_teacher_keywords') as $keyword)
            {
                $params = [
                    'keyword'           => $keyword,
                    'has_photo'         => 1,
                    'limit'             => 10
                ];
                $data['users'][$keyword] =  $userController->generate($params);
            }

            Cache::put($cache, $data['users'], 1440);
        }

        $cache = md5(json_encode('populars'));
        if(Cache::has($cache))
        {
            $data['populars'] = Cache::get($cache);
        }
        else
        {
            $data['populars'] = \App\Models\Level::orderBy('title')->limit(18)->offset(date('d') * 18)->get();
            Cache::put($cache, $data['populars'], 1440);
        }

        $cache = md5(json_encode('subjects'));
        if(Cache::has($cache))
        {
            $data['subjects'] = Cache::get($cache);
        }
        else
        {
            $data['subjects'] = \App\Models\Subject::get();
            Cache::put($cache, $data['subjects'], 1440);
        }

        $cache = md5(json_encode('cities'));
        if(Cache::has($cache))
        {
            $data['cities'] = Cache::get($cache);
        }
        else
        {
            $data['cities'] = \App\Models\Subject::get();
            Cache::put($cache, $data['cities'], 1440);
        }

        return view('welcome', $data);
    }

    public function theme(Request $request)
    {
        $domain = \App\Models\Domain::where('domain', $request->getHttpHost())->first();
        if(empty($domain))
        {
            return abort(404);
        }

        $user = \App\Models\User::findOrFail($domain->user_id);
        if(!empty($user))
        {
            $userController = new UserController;
            return $userController->show($user->username, 'themes.theme1');
        }
    }
}
