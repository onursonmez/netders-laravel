<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lang;
use Cache;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    protected $data = [];

    public function dashboard()
    {   
        $this->data['registrations'] = [];
        $this->data['messages'] = [];
        $this->data['view_phones'] = [];
        $this->data['views'] = [];

        $cache = md5(json_encode('admin_dashboard_registrations'));
        if(Cache::has($cache))
        {
            $this->data['registrations'] = Cache::get($cache);
        }
        else
        {        
            $dailyRegistrations = \App\Models\User::select('created_at')
            ->where('created_at', '>=', \Carbon\Carbon::now()->endOfMonth()->subMonth()->toDateString())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                //return \Carbon\Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return \Carbon\Carbon::parse($date->created_at)->format('m-d'); // grouping by months
            });
        
            foreach($dailyRegistrations as $key => $data)
            {
                $this->data['registrations'][$key] = $data->count();
            }
            Cache::put($cache, $this->data['registrations'], 1440);
        }

        $cache = md5(json_encode('admin_dashboard_messages'));
        if(Cache::has($cache))
        {
            $this->data['messages'] = Cache::get($cache);
        }
        else
        {        
            $dailyMessages = \App\Models\Conversation_message::select('created_at')
            ->where('created_at', '>=', \Carbon\Carbon::now()->endOfMonth()->subMonth()->toDateString())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                //return \Carbon\Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return \Carbon\Carbon::parse($date->created_at)->format('m-d'); // grouping by months
            });
        
            foreach($dailyMessages as $key => $data)
            {
                $this->data['messages'][$key] = $data->count();
            }
            Cache::put($cache, $this->data['messages'], 1440);
        }

        $cache = md5(json_encode('admin_dashboard_view_phones'));
        if(Cache::has($cache))
        {
            $this->data['view_phones'] = Cache::get($cache);
        }
        else
        {        
            $viewPhones = \App\Models\View_phone::select('created_at')
            ->where('created_at', '>=', \Carbon\Carbon::now()->endOfMonth()->subMonth()->toDateString())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                //return \Carbon\Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return \Carbon\Carbon::parse($date->created_at)->format('m-d'); // grouping by months
            });
        
            foreach($viewPhones as $key => $data)
            {
                $this->data['view_phones'][$key] = $data->count();
            }
            Cache::put($cache, $this->data['view_phones'], 1440);
        }    
        
        $cache = md5(json_encode('admin_dashboard_views'));
        if(Cache::has($cache))
        {
            $this->data['views'] = Cache::get($cache);
        }
        else
        {        
            $views = \App\Models\View::select('created_at')
            ->where('created_at', '>=', \Carbon\Carbon::now()->endOfMonth()->subMonth()->toDateString())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                //return \Carbon\Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return \Carbon\Carbon::parse($date->created_at)->format('m-d'); // grouping by months
            });
        
            foreach($views as $key => $data)
            {
                $this->data['views'][$key] = $data->count();
            }
            Cache::put($cache, $this->data['views'], 1440);
        }

        return view('admin.dashboard', $this->data);
    }

    public function photo_approval(Request $request)
    {   
        $photo = \App\Models\Photo::query();
        if($request->get('username'))
        {
            $username = $request->get('username');
            $photo->whereHas('user', function($q) use($username){
                $q->where('username', $username);
            });
        }
        else
        {
            $photo->where('approved', false);
        }
        
        $this->data['photo'] = $photo->first();

        if(empty($this->data['photo'])) return redirect('cp');
        
        return view('admin.photo_approval', $this->data);
    }

    public function photo_approval_save(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'id' => 'required',
        ]);

        $user = \App\Models\User::findOrFail($request->get('user_id'));
        $photo = \App\Models\Photo::findOrFail($request->get('id'));

        if ($request->hasFile('photo')) 
        {
            if ($request->file('photo')->isValid()) 
            {
                $request->validate([
                    'photo' => 'mimes:jpeg,png',
                ]);

                $file_name = $user->id . '-' . time() . '.' .  $request->file('photo')->getClientOriginalExtension();
                
                if(!\File::exists(storage_path('app/public/'.$photo->url)))
                \File::copy(public_path($photo->url), storage_path('app/public/users/'.$file_name));

                if(\File::exists(storage_path('app/public/users/'.$file_name)))
                {
                    $request->file('photo')->storeAs('users', $file_name, 'local');

                    if(\File::exists(public_path('users/'.$file_name)))
                    {
                        \File::delete(public_path($photo->url));
                        
                        $photo->url = 'users/' . $file_name;
                        $photo->approved = true;
                        $photo->save();                 

                        $img = Image::make(public_path('users/'.$file_name))->resize(300, 300)->insert(public_path('img/watermark.png'), 'bottom', 10, 10)->save();

                        
                    }
                }
            }
        }

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['success' => [Lang::get('auth.completed')]]);                                              
    } 
    
    public function photo_decline(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $photo = \App\Models\Photo::findOrFail($request->get('id'));
        \File::delete(public_path($photo->url));
        $photo->delete(); 

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['success' => [Lang::get('auth.completed')]]);                                              
    }     

    public function user_approval()
    {   
        $this->data['user'] = \App\Models\User::where('status', 'S')->first();
        if(empty($this->data['user'])) return redirect('cp');
        
        return view('admin.user_approval', $this->data);
    }    

    public function user_approval_save(Request $request)
    {   
        $user = \App\Models\User::findOrFail($request->get('id'));
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->status = 'A';
        $user->save();

        $detail = \App\Models\User_detail::where('user_id', $request->get('id'))->first();
        $detail->title = $request->get('title');
        $detail->long_text = $request->get('long_text');
        $detail->reference_text = $request->get('reference_text');
        $detail->save();        

        $mailClass = new \App\Mail\ProfileApproved($user);
        $message = $mailClass->onConnection('database')->onQueue('high');
        Mail::to($user->email)->queue($message);  
        
        return redirect('cp/user_approval');
    }        

    public function user_decline(Request $request)
    {   
        $request->validate([
            'id' => 'required',
        ]);

        $user = \App\Models\User::findOrFail($request->get('id'));
        $user->status = 'R';
        $user->save();

        $mailClass = new \App\Mail\ProfileDeclined($user, $request->get('message'));
        $message = $mailClass->onConnection('database')->onQueue('high');
        Mail::to($user->email)->queue($message);    

        return redirect('cp/user_approval');
    }        
}
