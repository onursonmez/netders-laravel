<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lang;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\UserRegistration;
use App\Mail\EmailConfirmation;
use App\Mail\UserForgot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Rules\mx_check;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check() || Auth::viaRemember()) {
            return redirect(url('users/dashboard'));
        }

        Session::put('redirect', $request->get('redirect') ?? url()->previous());

        $this->data['seo_title'] = Lang::get('auth.login');

        return view('auth.login', $this->data);
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'max:255', 'email', 'exists:users', new mx_check],
            'password'  => 'required',
            'captcha'  => 'required|integer|captcha',
        ]);          
        
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->get('email'))->where('status', 'C')->count();
        if($user > 0)
        {
            return $request->wantsJson()
            ? response()->json(['errors' => [Lang::get('auth.failed')]], 422)
            : redirect()->back()->withErrors(['errors' => [Lang::get('auth.failed')]]);            
        }

        $remember = $request->get('remember') == 1 ? true : false;
        if (Auth::attempt($credentials, $remember)) 
        {
            if(Auth::user()->group_id == 1)
            {
                Auth::user()->assignRole('admin');
            }

            $user = User::find(Auth::user()->id);
            $user->online = true;
            $user->save();

            Session::put('timezone', $user->timezone->code);

            broadcast(new \App\Events\UserOnline($user))->toOthers();

            $redirect = Session::get('redirect') ? Session::get('redirect') : url('users/dashboard');
            return $request->wantsJson()
                        ? response()->json(['redirect' => $redirect, 'success' => [Lang::get('auth.loggedin')]])
                        : redirect()->intended($redirect);
        }
        
        return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('auth.failed')]], 422)
                        : redirect()->back()->withErrors(['errors' => [Lang::get('auth.failed')]]);
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect(url('users/dashboard'));
        }        

        $this->data['seo_title'] = Lang::get('auth.register');

        return view('auth.register', $this->data);
    }

    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'email' => ['required', 'max:255', 'email', 'unique:users', new mx_check],
            'first_name'  => 'required|min:2|max:100',
            'last_name'  => 'required|max:100',
            'member_type'  => 'required|integer|in:1,2',
            'password'  => 'required|min:6|max:20',
            'captcha'  => 'required|integer|captcha',
        ]);      

        $user = new User;
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->group_id = $request->get('member_type') == 1 ? 2 : 3;
        $user->status = $request->get('member_type') == 1 ? 'A' : 'R';
        $user->search_point = $request->get('member_type') == 1 ? NULL : 1;        
        $user->username = time();
        $user->timezone_id = 16;     
        $user->save();
        $user_id = $user->id;

        $user_detail = new \App\Models\User_detail;
        $user_detail->user_id = $user_id;
        if($request->get('member_type') == 2)
        {
            $user_detail->privacy_lastname = 2;
            $user_detail->privacy_phone = 2;
            $user_detail->privacy_age = 2;
        }
        $user_detail->save();
        
        if($user_id)
        {
            $login_credentials = $request->only('email', 'password');

            if (Auth::attempt($login_credentials)) 
            {
                $this->activation_send('UserRegistration');           

                return $request->wantsJson()
                            ? response()->json(['redirect' => url('users/dashboard'), 'success' => [Lang::get('auth.loggedin')]])
                            : redirect()->intended('users/dashboard');
            }
        }
        
        return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('auth.failed')]], 422)
                        : redirect()->back()->withErrors(['errors' => [Lang::get('auth.failed')]]);        
    }

    public function activation_send($mailable)
    {
        $errors = [];
        $is_exists = \App\Models\Email_request::where('email', Auth::user()->email)->where('used', false)->first();
    
        if($is_exists && $is_exists->created_at >= Carbon::now()->subMinutes(10)->toDateTimeString())
        {
            $created = Carbon::createFromTimeStamp(strtotime($is_exists->created_at));
            $next = Carbon::now()->subMinutes(10)->toDateTimeString();
            $seconds_remaining = $created->diffInSeconds($next);

            $errors[] = Lang::get('auth.throttle', ['seconds' => $seconds_remaining]);
        }

        $email_request = new \App\Models\Email_request;
        $email_request->user_id = Auth::user()->id;
        $email_request->email = Auth::user()->email;
        $email_request->token = Hash::make(time());
        $email_request_saved = $email_request->save();

        if($email_request_saved)
        {
            $email_request->user = $email_request::find($email_request->id)->user;

            switch($mailable)
            {
                case 'UserRegistration';
                    $mailClass = new UserRegistration($email_request);
                break;

                case 'EmailConfirmation';
                    $mailClass = new EmailConfirmation($email_request);
                break;                
            }
            $message = $mailClass->onConnection('database')->onQueue('high');
            Mail::to(Auth::user()->email)->queue($message);  
        }

        return $errors;
    }

    public function forgot()
    {
        if (Auth::check()) {
            return redirect(url('users/dashboard'));
        }        

        return view('auth.forgot');
    } 
    
    public function do_forgot(Request $request)
    {
        $request->validate([
            'email'     => 'required|max:255|email|exists:users',
            'captcha'  => 'required|integer|captcha',
        ]);          

        $is_exists = \App\Models\Password_request::where('email', $request->get('email'))->where('used', false)->first();
        
        if($is_exists && $is_exists->created_at >= Carbon::now()->subMinutes(10)->toDateTimeString())
        {
            $created = Carbon::createFromTimeStamp(strtotime($is_exists->created_at));
            $next = Carbon::now()->subMinutes(10)->toDateTimeString();
            $seconds_remaining = $created->diffInSeconds($next);

            return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('auth.throttle', ['seconds' => $seconds_remaining])]], 422)
                        : redirect('auth/forgot')->withErrors(['errors' => [Lang::get('auth.throttle', ['seconds' => $seconds_remaining])]]);            
        }

        if(!$is_exists || $is_exists->created_at < Carbon::now()->subMinutes(10)->toDateTimeString())
        {
            if($is_exists)
            {
                $is_exists->delete();
            }

            $user = User::where('email', $request->get('email'))->first();

            $password_request = new \App\Models\Password_request;
            $password_request->user_id = $user->id;
            $password_request->email = $request->get('email');
            $password_request->token = Hash::make(time());
            $password_request_saved = $password_request->save();

            $password_request->user = $password_request::find($password_request->id)->user;

            if($password_request_saved)
            {
                $message = (new UserForgot($password_request))->onConnection('database')->onQueue('high');
                Mail::to($user->email)->queue($message);          
            }
        }

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.forgot_success')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.forgot_success')]]);        
    }   
    
    public function forgot_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|max:255|email|exists:users',
            'token'  => 'required',
        ]);

        if(!$validator->fails())
        {
            $is_exists = \App\Models\Password_request::where('email', $request->get('email'))->where('token', $request->get('token'))->where('used', false)->first();

            if($is_exists)
            {
                return view('auth.forgot_change')->with([
                    'email' => $request->get('email'),
                    'token' => $request->get('token')
                ]);
            }
        }

        return $request->wantsJson()
                    ? response()->json(['redirect' => url('auth/forgot'), 'errors' => [Lang::get('auth.forgot_error')]], 422)
                    : redirect('auth/forgot')->withErrors(['errors' => [Lang::get('auth.forgot_error')]]);
    }

    public function forgot_success(Request $request)
    {
        $request->validate([
            'email'     => 'required|max:255|email|exists:users',
            'new_password'  => 'required|min:6|max:20',
            'token'  => 'required',
            'captcha'  => 'required|integer|captcha',
        ]);

        $user = User::where('email', $request->get('email'))->first();
        if($user)
        {
            $is_exists = \App\Models\Password_request::where('email', $request->get('email'))->where('token', $request->get('token'))->where('used', false)->first();

            if($is_exists)
            {                
                $user->password = Hash::make($request->get('new_password'));
                $user_saved = $user->save();

                if($user_saved)
                {
                    $is_exists->used = true;
                    $is_exists->save();

                    return $request->wantsJson()
                                ? response()->json(['redirect' => url('auth/login'), 'success' => [Lang::get('auth.forgot_process_success')]])
                                : redirect(url('auth/login'))->with(['messages' => [Lang::get('auth.forgot_process_success')]]);                     
                }
            }
        }

        return $request->wantsJson()
                    ? response()->json(['errors' => [Lang::get('auth.forgot_error')]], 422)
                    : redirect('auth/forgot')->withErrors(['errors' => [Lang::get('auth.forgot_error')]]);        
    }

    public function activation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|max:255|email|exists:users',
            'token'  => 'required',
        ]);

        $redirect_url = Auth::check() ? url('users/dashboard') : url('auth/login');

        if(!$validator->fails())
        {
            $is_exists = \App\Models\Email_request::where('email', $request->get('email'))->where('token', $request->get('token'))->where('used', false)->first();

            if($is_exists)
            {
                $verified_emails_saved = \App\Models\Verified_email::updateOrCreate([
                    'user_id' => $is_exists->user_id,
                    'email' => $is_exists->email
                ]);

                if($verified_emails_saved)
                {
                    $verified_emails_saved->touch(); //update updated_at

                    $is_exists->used = true;
                    $is_exists->save();  
                    
                    $user = User::where('email', $request->get('email'))->first();
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                    
                    return $request->wantsJson()
                                ? response()->json(['redirect' => $redirect_url, 'success' => [Lang::get('auth.activation_success')]])
                                : redirect($redirect_url)->with(['messages' => [Lang::get('auth.activation_success')]]);                     
                }
            }
        }

        return $request->wantsJson()
                    ? response()->json(['redirect' => $redirect_url, 'errors' => [Lang::get('auth.activation_error')]], 422)
                    : redirect($redirect_url)->withErrors(['errors' => [Lang::get('auth.activation_error')]]);
    }

    public function logout()
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $user->online = false;
            $user->save();

            Auth::logout();
        } 

        return redirect(url('auth/login'));
    }      

    public function email_changing(Request $request)
    {
        $request->validate([
            'email'     => 'required|max:255|email|unique:users',
        ]);
        
        $verified_email = \App\Models\Verified_email::where('email', $request->get('email'))->where('user_id', Auth::user()->id)->first();
        if(empty($verified_email))
        {
            $is_exists = \App\Models\Email_request::where('email', $request->get('email'))->where('used', false)->first();
    
            if($is_exists && $is_exists->created_at >= Carbon::now()->subMinutes(10)->toDateTimeString())
            {
                $created = Carbon::createFromTimeStamp(strtotime($is_exists->created_at));
                $next = Carbon::now()->subMinutes(10)->toDateTimeString();
                $seconds_remaining = $created->diffInSeconds($next);
    
                return $request->wantsJson()
                            ? response()->json(['errors' => [Lang::get('auth.throttle', ['seconds' => $seconds_remaining])]], 422)
                            : redirect()->back()->withErrors(['errors' => [Lang::get('auth.throttle', ['seconds' => $seconds_remaining])]]);                
            }
    
            $email_request = new \App\Models\Email_request;
            $email_request->user_id = Auth::user()->id;
            $email_request->email = $request->get('email');
            $email_request->token = Hash::make(time());
            $email_request_saved = $email_request->save();
    
            if($email_request_saved)
            {    
                $message = (new EmailConfirmation($email_request))->onConnection('database')->onQueue('high');
                Mail::to($request->get('email'))->queue($message);  
            }
        }
        else
        {
            $verified_email->touch(); //update updated_at
        }

        $user = User::find(Auth::user()->id);
        $user->email = $request->get('email');
        $user->save();        

        return $request->wantsJson()
                    ? response()->json(['redirect' => url('email/change'), 'success' => [Lang::get('auth.completed')]])
                    : redirect(url('email/change'))->with(['messages' => [Lang::get('auth.completed')]]);          
    }

    public function resend_activation(Request $request)
    {
        $verified_email = \App\Models\Verified_email::where('email', Auth::user()->email)->where('user_id', Auth::user()->id)->first();
        if(empty($verified_email))
        {
            $is_exists = \App\Models\Email_request::where('email', Auth::user()->email)->where('used', false)->orderBy('created_at', 'desc')->first();
    
            if($is_exists)
            {
                
                if($is_exists->updated_at >= Carbon::now()->subMinutes(10)->toDateTimeString())
                {
                    $updated = Carbon::createFromTimeStamp(strtotime($is_exists->updated_at));
                    $next = Carbon::now()->subMinutes(10)->toDateTimeString();
                    $seconds_remaining = $updated->diffInSeconds($next);
        
                    return $request->wantsJson()
                                ? response()->json(['errors' => [Lang::get('auth.throttle', ['seconds' => $seconds_remaining])]], 422)
                                : redirect()->back()->withErrors(['errors' => [Lang::get('auth.throttle', ['seconds' => $seconds_remaining])]]);                
                }

                $message = (new EmailConfirmation($is_exists))->onConnection('database')->onQueue('high');
                Mail::to(Auth::user()->email)->queue($message);                              

                $is_exists->touch(); //update updated_at
            }
        }
        else
        {
            return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('auth.email_already_confirmed')]], 422)
                        : redirect(url('users/dashboard'))->withErrors(['errors' => [Lang::get('auth.email_already_confirmed')]]);                        
        }

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.email_activation_sent')]])
                    : redirect(url('users/dashboard'))->with(['messages' => [Lang::get('auth.email_activation_sent')]]);          
    }    

    public function username_changing(Request $request)
    {
        $request->validate([
            'username'  => 'required|max:100|unique:users|unique:usernames|regex:/^[a-z-]+$/',
        ]);

        $is_exists = \App\Models\Username::where('user_id', Auth::user()->id)->first();
        if(!empty($is_exists))
        {
            return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('auth.username_already_changed')]], 422)
                        : redirect(url('username/change'))->withErrors(['errors' => [Lang::get('auth.username_already_changed')]]);            
        }

        $user = User::find(Auth::user()->id);

        $username = new \App\Models\Username;
        $username->user_id = Auth::user()->id;
        $username->username = $user->username;
        $username->save();

        $user->username = $request->get('username');
        $user->save();       
        
        return $request->wantsJson()
                    ? response()->json(['redirect' => url('username/change'), 'success' => [Lang::get('auth.completed')]])
                    : redirect(url('username/change'))->with(['messages' => [Lang::get('auth.completed')]]);                  
    }

    public function password_changing(Request $request)
    {
        $request->validate([
            'old_password'  => 'required|min:6|max:20',
            'new_password'  => 'required|min:6|max:20|confirmed',
            'new_password_confirmation'  => 'required|min:6|max:20',
        ]);

        $user = User::find(Auth::user()->id);

        if(!Hash::check($request->get('old_password'), $user->password))
        {
            return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('auth.password_change_old_password_is_incorrect')]], 422)
                        : redirect(url('username/change'))->withErrors(['errors' => [Lang::get('auth.password_change_old_password_is_incorrect')]]);            
        }

        $user->password = Hash::make($request->get('new_password'));
        $user->save();
        
        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect(url('password/change'))->with(['messages' => [Lang::get('auth.completed')]]);                  
    }    
}
