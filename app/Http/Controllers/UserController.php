<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\User_detail;
use App\Models\User_figure;
use App\Models\User_place;
use App\Models\User_time;
use App\Models\User_service;
use App\Models\User_gender;
use App\Models\User_discount;
use Lang;
use Illuminate\Support\Facades\Redirect;
use Session;
use Cache;
use Str;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $data = [];

    public function search(Request $request, $citytown = null, $subjectlevel = null)
    {   
        $data = [];

		if($request->get('city_id') || $request->get('town_id') || $request->get('subject_id') || $request->get('level_id'))
		{
            return redirect($this->set_search_link($request), 301);
        }

        $citytownsubjectlevel   = $this->set_search_sessions($citytown, $subjectlevel);
        $params = [
            'seo_title'         => [],
            'seo_description'   => [],
            'page'              => $request->get('page'),
            'city_id'           => $citytownsubjectlevel['city_id'] ? (int)$citytownsubjectlevel['city_id'] : 34,
            'town_id'           => (int)$citytownsubjectlevel['town_id'],
            'subject_id'        => (int)$citytownsubjectlevel['subject_id'],
            'level_id'          => (int)$citytownsubjectlevel['level_id'],
            'price_min'         => $request->get('price_min') > 0 ? (int)$request->get('price_min') : 0,
            'price_max'         => $request->get('price_max') > 0 ? (int)$request->get('price_max') : 0,
            'figure'            => $request->get('figure') ? array_map('intval', array_values($request->get('figure'))) : null,
            'place'             => $request->get('place') ? array_map('intval', array_values($request->get('place'))) : null,
            'service'           => $request->get('service') ? array_map('intval', array_values($request->get('service'))) : null,
            'time'              => $request->get('time') ? array_map('intval', array_values($request->get('time'))) : null,
            'gender'            => $request->get('gender') ? $request->get('gender') : null,
            'keyword'           => $request->get('keyword') ? $request->get('keyword') : null,
            'group'             => $request->get('group') ? array_map('intval', array_values($request->get('group'))) : null,
            'has_photo'         => $request->get('has_photo') ? (int)$request->get('has_photo') : null,
            'live'              => $request->get('live') == 1 ? 1 : null,
            //'sort'              => $request->get('sort_price') ? 'sort_price' : 'search_point',
            //'by'                => $request->get('sort_price') ? $request->get('sort_price') : ($request->get('sort_point') ? $request->get('sort_point') : 'desc'),
            'sort'              => 'search_point',
            'by'                => 'desc',            
            'limit'             => 20
        ];

        Session::put('last_search', url()->full());

        if(!empty($params['city_id']))
        {
            $city = \App\Models\City::findOrFail($params['city_id']);
            $params['title']['city'] = $city->title;
            Session::put('city_slug', $city->slug);
        }

        if(!empty($params['keyword']))
        $params['title']['keyword'] = $params['keyword'];

        if(!empty($params['town_id']))
        $params['title']['town'] = \App\Models\Town::where('id',$params['town_id'])->pluck('title')->first();

        if(!empty($params['subject_id']))
        $params['title']['subject'] = \App\Models\Subject::where('id',$params['subject_id'])->pluck('title')->first();

        if(!empty($params['level_id']))
        $params['title']['level'] = \App\Models\Level::where('id',$params['level_id'])->pluck('title')->first();

        $data['users'] = $this->generate($params);

        $data['subjects'] = \App\Models\Subject::get();
        $data['cities'] = \App\Models\City::get();
        $data['params'] = json_decode(json_encode($params), false);
        $data['seo_title'] = $this->get_seo_title($params);
        $data['seo_description'] = $this->get_seo_description($params);
                
        return view('users.search', $data);
    }

    public function generate($params = [])
    {
        $cache = md5(json_encode($params));

        //if(Cache::has($cache))
        //{
        //    $users = Cache::get($cache);
        //}
        //else
        //{
            $query = User::whereIn('group_id', [3,4,5])->whereNotNull('search_point')->where('status', 'A')->with(['detail.city', 'detail.town', 'photo', 'prices', 'service_badge'])->has('prices')->orderBy($params['sort'] ?? 'id', $params['by'] ?? 'desc')->orderBy('updated_at', 'desc');

            if(!empty($params['keyword']))
            {
                $query->whereRaw('CONCAT(first_name, \' \', last_name) iLIKE ?', ['%'.$params['keyword'].'%']);

                $query->orWhereHas('prices.levels', function($q) use($params){
                    $q->where('title', 'ilike', '%'.$params['keyword'].'%');
                });                
            }

            if(!empty($params['live']))
            {
                $query = $query->has('lessons');
            }

            if(!empty($params['city_id']) && empty($params['live']))
            {
                $query = $query->whereHas('locations', function($q) use($params){
                    $q->where('city_id', $params['city_id']);
                });
            }

            if(!empty($params['town_id']) && empty($params['live']))
            {
                $query = $query->whereHas('locations.towns', function($q) use($params){
                    $q->where('id', $params['town_id']);
                });
            }

            if(!empty($params['subject_id']) && empty($params['live']))
            {
                $query = $query->whereHas('prices.subjects', function($q) use($params){
                    $q->where('id', $params['subject_id']);
                });
            }

            if(!empty($params['level_id']) && empty($params['live']))
            {
                $query = $query->whereHas('prices.levels', function($q) use($params){
                    $q->where('id', $params['level_id']);
                });
            }   
            
            if(!empty($params['price_min']))
            {
                $query = $query->whereHas('prices', function($q) use($params){
                    $q->where('price_private', '>=', $params['price_min'])->whereNotNull('price_private');
                    $q->orWhere('price_live', '>=', $params['price_min'])->whereNotNull('price_live');
                });
            }        
            
            if(!empty($params['price_max']))
            {
                $query = $query->whereHas('prices', function($q) use($params){
                    $q->where('price_private', '<=', $params['price_max'])->whereNotNull('price_private');
                    $q->orWhere('price_live', '<=', $params['price_max'])->whereNotNull('price_live');
                });
            }   

            if(!empty($params['figure']) && empty($params['live']))
            {
                $query = $query->whereHas('user_figures', function($q) use($params){
                    $q->whereIn('figure_id', $params['figure']);
                });
            }     
            
            if(!empty($params['place']) && empty($params['live']))
            {
                $query = $query->whereHas('user_places', function($q) use($params){
                    $q->whereIn('place_id', $params['place']);
                });
            }      
            
            if(!empty($params['service']) && empty($params['live']))
            {
                $query = $query->whereHas('user_services', function($q) use($params){
                    $q->whereIn('service_id', $params['service']);
                });
            }       
            
            if(!empty($params['time']) && empty($params['live']))
            {
                $query = $query->whereHas('user_times', function($q) use($params){
                    $q->whereIn('time_id', $params['time']);
                });
            }

            if(!empty($params['gender']) && empty($params['live']))
            {
                $query = $query->whereHas('detail', function($q) use($params){
                    $q->where('gender', $params['gender']);
                });
            }

            if(!empty($params['group']))
            {
                $query->whereIn('group_id', $params['group']);
            }            

            if(!empty($params['has_photo']))
            {
                $query = $query->has('has_photo');
            }

            $users = $query->paginate($params['limit'] ?? 20);

        //    Cache::put($cache, $users, 1440);
        //}

        return $users;
    }

    public function show($username, $template = 'users.show')
    {
        $user = User::with(['detail', 'user_figures', 'user_places', 'user_services', 'user_times', 'user_genders', 'user_discounts', 'prices', 'comments'])->where('username', $username)->first();
        if(!empty($user))
        {
            $this->data['user'] = $user;
        }
        else
        {
            return abort(404);
        }

        $view = new \App\Models\View;
        $view->user_id = $user->id;
        $view->ip = request()->ip();
        $view->save();

        $this->data['figures'] = \App\Models\Figure::get();
        $this->data['services'] = \App\Models\Service::get();
        $this->data['places'] = \App\Models\Place::get();
        $this->data['times'] = \App\Models\Time::get();
        $this->data['genders'] = \App\Models\Gender::get();
        $this->data['discounts'] = \App\Models\Discount::get();
        
        $this->data['definition'] = \App\Models\Calendar_definition::where('user_id', $user->id)->first();
        if(!empty($this->data['definition']))
        {
            $this->data['lessons'] = \App\Models\Calendar_lesson::where('teacher_id', $user->id)->where('start_at', '>=', \Carbon\Carbon::now()->setTimezone(Auth::user()->timezone->code ?? 'Europe/Istanbul'))->get();
            $this->data['exceptions'] = \App\Models\Calendar_exception::where('user_id', $user->id)->where('from_date', '>=', \Carbon\Carbon::now()->setTimezone(Auth::user()->timezone->code ?? 'Europe/Istanbul'))->get();
            $this->data['definition_min'] = \App\Models\Calendar_definition::where('user_id', $user->id)->selectRaw("LEAST(min(tz(d1_from::timetz, '{$user->timezone->code}')), min(tz(d1_to::timetz, '{$user->timezone->code}')), min(tz(d2_from::timetz, '{$user->timezone->code}')), min(tz(d2_to::timetz, '{$user->timezone->code}')), min(tz(d3_from::timetz, '{$user->timezone->code}')), min(tz(d3_to::timetz, '{$user->timezone->code}')), min(tz(d4_from::timetz, '{$user->timezone->code}')), min(tz(d4_to::timetz, '{$user->timezone->code}')), min(tz(d5_from::timetz, '{$user->timezone->code}')), min(tz(d5_to::timetz, '{$user->timezone->code}')), min(tz(d6_from::timetz, '{$user->timezone->code}')), min(tz(d6_to::timetz, '{$user->timezone->code}')), min(tz(d7_from::timetz, '{$user->timezone->code}')), min(tz(d7_to::timetz, '{$user->timezone->code}'))) AS min")->first()->min;
            $this->data['definition_max'] = \App\Models\Calendar_definition::where('user_id', $user->id)->selectRaw("GREATEST(max(tz(d1_from::timetz, '{$user->timezone->code}')), max(tz(d1_to::timetz, '{$user->timezone->code}')), max(tz(d2_from::timetz, '{$user->timezone->code}')), max(tz(d2_to::timetz, '{$user->timezone->code}')), max(tz(d3_from::timetz, '{$user->timezone->code}')), max(tz(d3_to::timetz, '{$user->timezone->code}')), max(tz(d4_from::timetz, '{$user->timezone->code}')), max(tz(d4_to::timetz, '{$user->timezone->code}')), max(tz(d5_from::timetz, '{$user->timezone->code}')), max(tz(d5_to::timetz, '{$user->timezone->code}')), max(tz(d6_from::timetz, '{$user->timezone->code}')), max(tz(d6_to::timetz, '{$user->timezone->code}')), max(tz(d7_from::timetz, '{$user->timezone->code}')), max(tz(d7_to::timetz, '{$user->timezone->code}'))) AS max")->first()->max;
        }
        $city = isset($user->detail->city->title) ? $user->detail->city->title : '';
        $this->data['seo_title'] = $user->first_name . ' ' . $user->last_name . ' ' . Lang::get('general.profile_page') . ' '. $city;

        return view($template, $this->data);
    }

    public function required()
    {
        $this->data['required'] = Auth::user()->required();

        return view('users.required', $this->data);
    }

    public function review()
    {
        if(empty(Auth::user()->required()))
        {
            $user = Auth::user();
            $user->status = 'S';
            $user->save();

            return redirect('users/dashboard');
        }
        else
        {
            return redirect('users/required')->withErrors(['errors' => [Lang::get('auth.missing_profile_fields')]]);            
        }
    }    

    public function dashboard(Request $request)
    {
        $cache = md5(json_encode('views_'.Auth::user()->id));

        if(Cache::has($cache))
        {
            $this->data['views'] = Cache::get($cache);
        }
        else
        {        
            $this->data['views'] = [];
            $query = \App\Models\View::where('user_id', Auth::user()->id)->where('created_at', '>=', \Carbon\Carbon::now()->subDays(365))->orderBy('created_at')->get()->groupBy(function($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m-Y');
            })->toArray();
        
            foreach($query as $key => $data)
            {
                $this->data['views'][$key] = count($data);
            }

            Cache::put($cache, $this->data['views'], 1440);
        }

        $products = [];
        \App\Models\Product::all()->map(function($item) use(&$products) {
            $products[$item->id] = $item->toArray();
        });
        $this->data['product'] = $products;

        $this->data['live_lesson'] = \App\Models\Calendar_lesson::where(function($query){
            $query->where('student_id', Auth::user()->id)->orWhere('teacher_id', Auth::user()->id);
        })->where('status', 'A')->where('start_at', '>=', \Carbon\Carbon::now())->orderBy('start_at', 'asc')->first();

        return view('users.dashboard', $this->data);
    }    

    public function personal(Request $request)
    {
        $this->data['timezones'] = \App\Models\Timezone::get();
        $this->data['cities'] = \App\Models\City::get();
        $this->data['professions'] = \App\Models\Profession::get();

        return view('users.personal', $this->data);
    }    

    public function personal_save(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->fill($request->all())->save();

        $detail = User_detail::where('user_id', Auth::user()->id)->first();
        if(empty($detail))
        {
            $detail = new User_detail;
        }
        $detail->user_id = Auth::user()->id;
        $detail->fill($request->all())->save();

        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $request->validate([
                    'photo' => 'mimes:jpeg,png|max:1014',
                ]);
                $file_name = Auth::user()->id . '-' . time() . '.' .  $request->file('photo')->getClientOriginalExtension();
                $folder = '/users';
                $uploaded_file = $request->file('photo')->storeAs($folder, $file_name, 'local');
                if($uploaded_file)
                {
                    Auth::user()->delete_all_pending_photos();

                    $file = \App\Models\Photo::create([
                        'user_id' => Auth::user()->id,
                        'url' => $uploaded_file,
                        'approved' => false,
                        'main' => 't'
                    ]);                    
                }
            }
        }

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);  
    }

    public function delete_photo(Request $request)
    {
        if(Auth::user()->photo->id == $request->get('id'))
        {
            if(file_exists(public_path(Auth::user()->photo->url)))
            {
                if(unlink(public_path(Auth::user()->photo->url)))
                {
                    $photo = \App\Models\Photo::find(Auth::user()->photo->id);
                    $photo->delete();

                    return $request->wantsJson()
                                ? response()->json(['success' => [Lang::get('auth.completed')]])
                                : redirect()->back()->with(['success' => [Lang::get('auth.completed')]]);                      
                }
            }
        }
    }    

    public function informations(Request $request)
    {
        return view('users.informations');
    }

    public function informations_save(Request $request)
    {
        $detail = User_detail::where('user_id', Auth::user()->id)->first();
        if(empty($detail))
        {
            $detail = new User_detail;
        }
        $detail->user_id = Auth::user()->id;
        $detail->fill($request->all())->save();

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);          
    }

    public function preferences(Request $request)
    {
        $this->data['figures'] = \App\Models\Figure::get();
        $this->data['services'] = \App\Models\Service::get();
        $this->data['places'] = \App\Models\Place::get();
        $this->data['times'] = \App\Models\Time::get();
        $this->data['genders'] = \App\Models\Gender::get();
        $this->data['discounts'] = \App\Models\Discount::get();

        return view('users.preferences', $this->data);
    } 
    
    public function preferences_save(Request $request)
    {
        $detail = User_detail::where('user_id', Auth::user()->id)->first();
        if(empty($detail))
        {
            $detail = new User_detail;
        }

        $detail->user_id = Auth::user()->id;
        $detail->privacy_lastname = $request->get('privacy_lastname');
        $detail->privacy_phone = $request->get('privacy_phone');        
        $detail->privacy_age = $request->get('privacy_age');        
        $detail->email_list = $request->get('email_list');        
        $detail->save();

        User_figure::where('user_id', Auth::user()->id)->delete();
        User_place::where('user_id', Auth::user()->id)->delete();
        User_time::where('user_id', Auth::user()->id)->delete();
        User_service::where('user_id', Auth::user()->id)->delete();
        User_gender::where('user_id', Auth::user()->id)->delete();

        if(!empty($request->get('figures')))
        {
            foreach($request->get('figures') as $id)
            {
                $figure = new User_figure;
                $figure->user_id = Auth::user()->id;
                $figure->figure_id = $id;
                $figure->save();  
            }
        }

        if(!empty($request->get('services')))
        {
            foreach($request->get('services') as $id)
            {
                $service = new User_service;
                $service->user_id = Auth::user()->id;
                $service->service_id = $id;
                $service->save();  
            }
        }
        
        if(!empty($request->get('times')))
        {
            foreach($request->get('times') as $id)
            {
                $time = new User_time;
                $time->user_id = Auth::user()->id;
                $time->time_id = $id;
                $time->save();  
            }
        }
        
        if(!empty($request->get('places')))
        {
            foreach($request->get('places') as $id)
            {
                $place = new User_place;
                $place->user_id = Auth::user()->id;
                $place->place_id = $id;
                $place->save();  
            }
        }
        
        if(!empty($request->get('genders')))
        {
            foreach($request->get('genders') as $id)
            {
                $gender = new User_gender;
                $gender->user_id = Auth::user()->id;
                $gender->gender_id = $id;
                $gender->save();  
            }
        }        
                      
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);          
    }   
    
    public function discounts(Request $request)
    {
        $this->data['discounts'] = \App\Models\Discount::orderBy('id')->get();

        return view('users.discounts', $this->data);
    }     

    public function discounts_save(Request $request)
    {
        User_discount::where('user_id', Auth::user()->id)->delete();
        
        if(!empty($request->get('discount')))
        {
            foreach($request->get('discount') as $id => $value)
            {
                if($request->get('discount')[$id] > 0)
                {
                    $discount = new User_discount;
                    $discount->user_id = Auth::user()->id;
                    $discount->discount_id = $id;
                    $discount->rate = $request->get('discount')[$id];
                    $discount->description = !empty($request->get('discount_description')[$id]) ? $request->get('discount_description')[$id] : NULL;
                    $discount->save();  
                }
            }
        }

        User::calculate_search_point(Auth::user()->id);
        
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);          
    }   

    public function memberships(Request $request)
    {
        return view('users.memberships', $this->data);
    }     

    private function set_search_link($request)
    {
		$url = array();

		parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $query_strings);

		$url = 'ozel-ders-ilanlari-verenler/';

		if($request->get('town_id'))
		{
            $town_slug = \App\Models\Town::where('id', $request->get('town_id'))->pluck('slug')->first();
            $url .= $town_slug;
            unset($query_strings['city_id']);
			unset($query_strings['town_id']);
        }
        else
        {
            if($request->get('city_id'))
            {
                $city_slug = \App\Models\City::where('id', $request->get('city_id'))->pluck('slug')->first();
                $url .= $city_slug;
                unset($query_strings['city_id']);
            } else {
                $city_slug = \App\Models\City::where('id', Session::get('site_city'))->pluck('slug')->first();
                $url .= $city_slug;
                unset($query_strings['city_id']);
            }
        }

		$url .= '/';

        if($request->get('level_id'))
        {
            $level_slug = \App\Models\Level::where('id', $request->get('level_id'))->pluck('slug')->first();
            $url .= $level_slug;
            unset($query_strings['subject_id']);
			unset($query_strings['level_id']);
        }
        else
        {
            if($request->get('subject_id'))
            {
                $subject_slug = \App\Models\Subject::where('id', $request->get('subject_id'))->pluck('slug')->first();
                $url .= $subject_slug;
                unset($query_strings['subject_id']);
            }            
        }

		if($request->get('subject_id') || $request->get('level_id'))
		$url .= '/';

		$query_strings = !empty($query_strings) ? '?' . http_build_query($query_strings) : '';

        $response = url($url . $query_strings);

        return $request->wantsJson()
                    ? response()->json($response)
                    : $response;
    }

    private function set_search_sessions($citytown, $subjectlevel)
    {
        $city_id = null;
        $town_id = null;
        $subject_id = null;
        $level_id = null;
        
        if($citytown)
        {
            $town = \App\Models\Town::where('slug', $citytown)->first();
            if(!empty($town))
            {
                $city_id = $town->city_id;
                $town_id = $town->id;
                Session::put('site_city', $city_id);
                Session::put('site_town', $town_id);
            }
            else
            {
                $city = \App\Models\City::where('slug', $citytown)->first();
                if(!empty($city))
                {
                    $city_id = $city->id;
                    Session::put('site_city', $city_id);
                    Session::forget('site_town');
                }
                else
                {
                    Session::forget('site_city');
                    Session::forget('site_town');
                }
            }
        }
        else
        {
            Session::forget('site_city');
            Session::forget('site_town');
        }
        
        if($subjectlevel)
        {
            $level = \App\Models\Level::where('slug', $subjectlevel)->first();
            if(!empty($level))
            {
                $subject_id = $level->subject_id;
                $level_id = $level->id;
                Session::put('site_subject', $subject_id);
                Session::put('site_level', $level_id);                
            }
            else
            {
                $subject = \App\Models\Subject::where('slug', $subjectlevel)->first();
                if(!empty($subject))
                {
                    $subject_id = $subject->id;
                    Session::put('site_subject', $subject_id);
                    Session::forget('site_level');
                }
                else
                {
                    Session::forget('site_subject');
                    Session::forget('site_level');                    
                }
            }
        }
        else
        {
            Session::forget('site_subject');
            Session::forget('site_level');
        }        

        return ['city_id' => $city_id, 'town_id' => $town_id, 'subject_id' => $subject_id, 'level_id' => $level_id];
    }

    public function new_message()
    {
        $returnHTML = view('users.load_new_message')->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }

    public function new_comment(Request $request)
    {
        $returnHTML = view('users.load_new_comment')->with('form_url', $request->get('form_url'))->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }    

    public function new_complaint()
    {
        $returnHTML = view('users.load_new_complaint')->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }        

    public function send_comment(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',
        ]);      
        
        $comment = new \App\Models\Comment;
        $comment->user_id = $request->get('data_id');
        $comment->creator_id = Auth::user()->id;
        $comment->comment = $request->get('comment');
        $comment->rating = $request->get('rating');
        
        $comment->save();   
        
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('comment.send_success')]])
                    : redirect()->back()->with(['messages' => [Lang::get('comment.send_success')]]);  
    }
    
    public function send_complaint(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|max:255|email',
            'phone_mobile' => 'required',
            'message' => 'required',
        ]);      
        
        $complaint = new \App\Models\Complaint;
        $complaint->user_id = $request->get('data_id');
        $complaint->first_name = $request->get('first_name');
        $complaint->last_name = $request->get('last_name');
        $complaint->email = $request->get('email');
        $complaint->phone_mobile = $request->get('phone_mobile');
        $complaint->message = $request->get('message');
        $complaint->save();   
        
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('complaint.send_success')]])
                    : redirect()->back()->with(['messages' => [Lang::get('complaint.send_success')]]);  
    }
    
    public function activities()
    {
        $this->data['orders'] = \App\Models\Order::where('user_id', Auth::user()->id)->orderBy('start_at', 'desc')->get();

        return view('users.activities', $this->data);
    }

    private function get_seo_title($params)
    {
        if(isset($params['title']['town']))
        {
            $params['seo_title'][] = $params['title']['town'];
        }
        else
        {
            if(isset($params['title']['city']))
            {
                $params['seo_title'][] = $params['title']['city'];
            }
        }

        if(isset($params['title']['subject']) && !isset($params['title']['level']))
        {
            $params['seo_title'][] = $params['title']['subject'];
        }

        if(isset($params['title']['level']))
        {
            $params['seo_title'][] = $params['title']['level'];
        }

        if(isset($params['keyword']))
        {
            $params['seo_title'][] = txtWordUpper($params['keyword']);
        }  
        
        $params['seo_title'][] = Lang::get('general.private_lesson_teachers');

        if(isset($params['title']['level']))
        {
            $params['seo_title'][] = "- " . $params['title']['subject'];
        }        

        return implode(' ', $params['seo_title']);
    }
    
    private function get_seo_description($params)
    {   
        if(isset($params['title']['town']))
        {
            $params['seo_title'][] = $params['title']['town'];
        }
        else
        {
            if(isset($params['title']['city']))
            {
                $params['seo_title'][] = $params['title']['city'];
            }
        }

        $params['seo_title'][] = Lang::get('general.by_created_lesson');

        if(isset($params['title']['level']))
        {
            $params['seo_title'][] = txtLower($params['title']['level']);
        }
        else
        {
            if(isset($params['title']['subject']))
            {
                $params['seo_title'][] = txtLower($params['title']['subject']);
            }
        }

        if(isset($params['keyword']))
        {
            $params['seo_title'][] = txtWordUpper($params['keyword']);
        }  

        $params['seo_title'][] = Lang::get('general.by_created_here');
                
        if(isset($params['title']['level']))
        {
            $params['seo_title'][] = "- " . $params['title']['subject'];
        }           

        return implode(' ', $params['seo_title']);
    }    

    public function mobile_phone(Request $request)
    {
        $phone = null;

        $request->validate([
            'hash' => 'required',
        ]);    

        if(
			stristr($request->server('HTTP_USER_AGENT'), 'Google') ||
			stristr($request->server('HTTP_USER_AGENT'), 'Yandex') ||
			stristr($request->server('HTTP_USER_AGENT'), 'MegaIndex')
		){
			return false;
        }        
        
        $user_id = Crypt::decryptString($request->get('hash'));

        $user_detail = User_detail::where('user_id', $user_id)->firstOrFail();

        if(!empty($user_detail))
        {
            if($user_detail->privacy_phone == 1)
            {
                $daily_view_by_ip = \App\Models\View_phone::where('ip', request()->ip())->where('created_at', '>=', \Carbon\Carbon::today())->where('created_at', '<=', \Carbon\Carbon::now())->count();
                if($daily_view_by_ip > 20)
                {
                    $newext = rand(1000,9999);
                    $phone = str_replace(substr($user_detail->phone_mobile, -4), $newext, $user_detail->phone_mobile);                
                }
                else
                {
                    $view_phone = new \App\Models\View_phone;
                    $view_phone->viewer_user_id = Auth::check() ? Auth::user()->id : null;
                    $view_phone->teacher_user_id = $user_id;
                    $view_phone->ip = request()->ip();
                    $view_phone->user_agent = $request->server('HTTP_USER_AGENT');
                    $view_phone->save();
                    $view_phone_id = $view_phone->id;

                    if($view_phone_id)
                    $phone = $user_detail->phone_mobile;
                }        
            }
        }

        return response()->json([$phone]);
    }

    public function cancellation(Request $request)
    {
        if(!empty($request->all()))
        {
            $request->validate([
                'password' => 'required|same:password',
                'cancel_reason' => 'required',
            ]);        
            if(!Hash::check($request->get('password'), Auth::user()->password))
            {
                return $request->wantsJson()
                            ? response()->json(['errors' => [Lang::get('auth.current_password_incorrect')]], 422)
                            : redirect()->back()->withErrors(['errors' => [Lang::get('auth.current_password_incorrect')]]);                 
            }

            $cancel = new \App\Models\Cancel;
            $cancel->user_id = Auth::user()->id;
            $cancel->reason = $request->get('cancel_reason');
            $cancel->last_status = Auth::user()->status;
            $cancel->save();

            Auth::user()->update(['status' => 'C']);

            Auth::logout();
            
            $redirect = Session::get('redirect') ? Session::get('redirect') : url('auth/login');
            return $request->wantsJson()
                        ? response()->json(['redirect' => $redirect, 'success' => [Lang::get('auth.cancelled')]])
                        : redirect()->intended($redirect)->with(['messages' => [Lang::get('auth.cancelled')]]);        

        }

        return view('users.cancellation');
    }

    public function cron1min()
    {
        //Yeni mesajlari mail gonder (aktif olanlara)
        /*
        $items = \App\Models\Conversation_participant::whereNotNull('unread')->where(function($query){
            $query->where('email_at', null)->orWhere('email_at', '<', \Carbon\Carbon::now()->subDay());
        })->whereHas('user', function($q){
            $q->where('online', false);
            $q->where('status', 'A');
        })->get();
        */
        
        if($items->count() > 0)
        {
            foreach($items as $item)
            {
                $user = User::find($item->user_id);
                $mailClass = new \App\Mail\NewMessage($user);
                $message = $mailClass->onConnection('database')->onQueue('high');
                Mail::to($user->email)->queue($message);   
                
                $participant = \App\Models\Conversation_participant::where('user_id', $item->user_id)->update(['email_at' => \Carbon\Carbon::now()]);
            }
        }
        
    }    

    public function cron30min()
    {
        //30 dakikadır hareketsiz kullanıcıları offline yap
        User::where('online', true)->where('updated_at', '<', \Carbon\Carbon::now()->subMinutes(30))->update(['online' => false]);
        
        //Expire olmus urunleri sil, user point guncelle
        $orders = \App\Models\Order::where('expired', 'f')->where('end_at', '<', \Carbon\Carbon::now())->get();
        if(!empty($orders))
        {
            foreach($orders as $order)
            {
                \App\Models\Order::where('id', $order->id)->update(['expired' => 't']);
                User::calculate_search_point($order->user_id);
            }
        }

        //Alisveris sepetteki dunku eski urunleri kaldir
        \App\Models\Cart::where('status', 'W')->where('created_at', '<', \Carbon\Carbon::yesterday())->delete();

        //Ders sepetindeki 30 dakikadan eski urunleri kaldir
        \App\Models\Calendar_lesson::where('status', 'W')->where('created_at', '<', \Carbon\Carbon::now()->subMinutes(30))->delete();        

        //!!!pazaryeri aktif olunca calendar_lessons da D ve C durumundaki dersleri işleme al. açıklaması calendarcontroller.php de !!!

        //!!!7 günü geçmiş aktif ders versa durumunu C yap yani otomatik ödeme onayı ver!!!
    }    

    public function badge()
    {
        return view('users.badge');
    }

    public function badge_save(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:jpeg,png,pdf|max:1024',
        ]);

        if ($request->hasFile('document') && !empty(Auth::user()->service_badge) && Auth::user()->service_badge->status == 'W')
        {
            $check_olds = \App\Models\Badge::where('user_id', Auth::user()->id)->get();
            if(!empty($check_olds))
            {
                foreach($check_olds as $check)
                {
                    if(unlink(public_path($check->url)))
                    {
                        $check->delete();
                    }                    
                }
            }
            if ($request->file('document')->isValid()) {
                
                $file_name = Auth::user()->id . '-' . time() . '.' .  $request->file('document')->getClientOriginalExtension();
                $folder = '/badge';
                $uploaded_file = $request->file('document')->storeAs($folder, $file_name, 'local');
                if($uploaded_file)
                {
                    $file = \App\Models\Badge::create([
                        'user_id' => Auth::user()->id,
                        'order_id' => Auth::user()->service_badge->id,
                        'url' => $uploaded_file,
                    ]);     
                    
                    $order = \App\Models\Order::where('user_id', Auth::user()->id)->where('product_id', 10)->where('status', 'W')->first();
                    $order->status = 'P';
                    $order->save();
                }
            }
        }

        return $request->wantsJson()
                    ? response()->json(['redirect' => url('users/dashboard'), 'success' => [Lang::get('auth.completed')]])
                    : redirect('users/dashboard')->with(['messages' => [Lang::get('auth.completed')]]);  
    }    

    public function domain()
    {
        if(!Auth::user()->domain('W')) 
            return redirect('users/dashboard');

        return view('users.domain');
    }

    public function domain_check(Request $request)
    {
        if(!Auth::user()->domain('W')) return false;

        $request->validate([
            'domain' => 'required',
            'ext' => 'required',
        ]);           

        $domain_name = $request->get('domain') . $request->get('ext');

        if (gethostbyname($domain_name) != $domain_name) 
        {
            return redirect('domain')->with(['success' => false, 'domain' => $request->get('domain'), 'ext' => $request->get('ext'), 'message' => Lang::get('general.domain_exist')]);  
        }
        else 
        {
            return redirect('domain')->with(['success' => true, 'domain' => $request->get('domain'),'ext' => $request->get('ext'), 'message' => Lang::get('general.domain_available')]);  
        }        
    }    

    public function domain_select(Request $request)
    {
        if(!Auth::user()->domain('W')) return false;
        
        $request->validate([
            'domain' => 'required',
            'ext' => 'required',
        ]);     

        \App\Models\Domain::create([
            'user_id' => Auth::user()->id,
            'order_id' => Auth::user()->domain('W')->id,
            'domain' => $request->get('domain') . $request->get('ext'),
        ]);     
        
        $order = Auth::user()->domain('W');
        $order->status = 'P';
        $order->save();

        return redirect('users/dashboard')->with(['messages' => [Lang::get('auth.completed')]]);  
    }    

    public function domain_send_message(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'phone_mobile' => 'required',
            'message' => 'required',
        ]);      

        $domain = \App\Models\Domain::where('domain', $request->getHttpHost())->first();
        if(empty($domain))
        {
            return abort(404);
        }

        $user = \App\Models\User::findOrFail($domain->user_id);
        $message = collect([
            'full_name' => $request->get('full_name'),
            'email' => $request->get('email'),
            'phone_mobile' => $request->get('phone_mobile'),
            'message' => $request->get('message')
        ]);
        
        $mailClass = new \App\Mail\DomainNewMessage($user, $message);
        $message = $mailClass->onConnection('database')->onQueue('high');
        Mail::to($user->email)->queue($message);        
        
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('chat.send_success')]])
                    : redirect()->back()->with(['messages' => [Lang::get('chat.send_success')]]);  
    }   
}
