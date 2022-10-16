<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExchangeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SetupApplication;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');

Route::get('/datetest', function () {
    //return view('welcome');
    echo \Carbon\Carbon::createFromTimestamp(substr(1615672500000,0,10))->toDateTimeString();
});

Route::get('/exchange/importSymbols', [ExchangeController::class, 'importSymbols']);
Route::get('/exchange/importPrices', [ExchangeController::class, 'importPrices']);
Route::get('/exchange/average', [ExchangeController::class, 'average']);
Route::get('/exchange/drop', [ExchangeController::class, 'drop']);

Route::get('testable', function ()
{
    //$user = \App\Models\User::findOrFail(873);
    //Mail::to($user->email)->send(new \App\Mail\NewMessage($user));

    /*
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://www.ozelders.com/Ajax/LoadClassCategoriesForHomePage/509");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);

    $data = json_decode($server_output);

    foreach($data as $level)
    {
        $exist = \App\Models\Level::where('title', $level->Name)->where('subject_id', 14)->first();
        if(empty($exist) && $level->Name != 'Tüm Konular')
        {
            $insert = new \App\Models\Level;
            $insert->old_id = 0;
            $insert->title = $level->Name;
            $insert->subject_id = 14;
            $insert->slug = 'oyun-ve-hobi/'.\Str::slug($level->Name);
            $insert->save();


            echo $level->Name."<br />";
        }
    }
    */
});

/*

Route::get('mailable', function () {
    $user = \App\Models\User::findOrFail(874);
    $message = collect([
        'full_name' => "demo demo",
        'email' => "aa@aa.com",
        'phone_mobile' => "053233874646",
        'message' => "mesajım böyle"
    ]);
    return new App\Mail\DomainNewMessage($user, $message);
});


Route::get('autologin/{id}', function ($id) {
    $user = App\Models\User::where('username', $id)->first();
    Auth::login($user);

    return redirect('users/dashboard');
});


Route::get('autologin/{id}', function ($id) {
    $user = App\Models\User::where('id', $id)->first();
    Auth::login($user);

    return redirect('users/dashboard');
});


Route::get('update_user_points', function () {
    ini_set('memory_limit', '2048M');
    $users = App\Models\User::whereIn('group_id', [3,4,5])->get();
    foreach($users as $user)
    {
        \App\Models\User::calculate_search_point($user->id);
    }
});
*/

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('autologin/{id}', function ($id) {
        $user = App\Models\User::where('id', $id)->first();
        Auth::login($user);

        return redirect('users/dashboard');
    });

    Route::get('orderable', function () {
        $data = new \Illuminate\Http\Request([
            'merchant_oid'   => 7620001612516370,
            'status'  => 'success',
            'total_amount' => '5000'
        ]);

        $hash = base64_encode( hash_hmac('sha256', $data->get('merchant_oid') . '1tbxU28PRthzEJ2J' . $data->get('status') . $data->get('total_amount'), '1yonBuzJQ3wkMtra', true) );
        $data->request->add(['hash' => $hash]);

        $cartController = new \App\Http\Controllers\CartController;
        $cartController->payment_notify($data);
    });
});

Route::middleware([SetupApplication::class])->group(function () {

if(!in_array(request()->getHttpHost(), ['nd.io', 'netders.com', 'dev.netders.com', '127.0.0.1:8000']))
{
    Route::post('users/mobile_phone', [UserController::class, 'mobile_phone'])->name('users/mobile_phone')->middleware('throttle:auth');
    Route::post('send_message', [UserController::class, 'domain_send_message'])->name('domain_send_message')->middleware('throttle:auth');
    Route::get('/', [HomeController::class, 'theme'])->name('theme');
}
else
{
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('cp', [AdminController::class, 'dashboard'])->name('cp')->middleware('auth');
        Route::get('cp/photo_approval', [AdminController::class, 'photo_approval'])->name('cp/photo_approval')->middleware('auth');
        Route::post('cp/photo_approval', [AdminController::class, 'photo_approval_save'])->name('cp/photo_approval_save')->middleware('auth');
        Route::post('cp/photo_decline', [AdminController::class, 'photo_decline'])->name('cp/photo_decline')->middleware('auth');
        Route::get('cp/user_approval', [AdminController::class, 'user_approval'])->name('cp/user_approval')->middleware('auth');
        Route::post('cp/user_approval', [AdminController::class, 'user_approval_save'])->name('cp/user_approval_save')->middleware('auth');
        Route::post('cp/user_decline', [AdminController::class, 'user_decline'])->name('cp/user_decline')->middleware('auth');
    });

    Route::get('cron1min', [UserController::class, 'cron1min'])->name('cron1min');
    Route::get('cron30min', [UserController::class, 'cron30min'])->name('cron30min');

    Route::get('/', [HomeController::class, 'index'])->name('welcome');
    Route::get('calendar/get', [CalendarController::class, 'get'])->name('calendar/get')->middleware('auth');
    Route::post('calendar/set', [CalendarController::class, 'set'])->name('calendar/set')->middleware('auth');
    Route::post('calendar/add', [CalendarController::class, 'add'])->name('calendar/add')->middleware('auth');
    Route::post('calendar/check', [CalendarController::class, 'check'])->name('calendar/check')->middleware('auth');
    Route::post('calendar/load_lessons', [CalendarController::class, 'load_lessons'])->name('calendar/load_lessons')->middleware('auth');
    Route::post('calendar/exception_save', [CalendarController::class, 'exception_store'])->name('calendar/exception_save')->middleware('auth');
    Route::get('calendar/exception_delete/{id}', [CalendarController::class, 'exception_delete'])->name('calendar/exception_delete')->middleware('auth');
    Route::get('calendar/lessons', [CalendarController::class, 'lessons'])->name('calendar/lessons')->middleware('auth');
    Route::get('calendar/change/{lesson_id}', [CalendarController::class, 'change'])->name('calendar/change')->middleware('auth');
    Route::post('calendar/change', [CalendarController::class, 'change_save'])->name('calendar/change_save')->middleware('auth');
    Route::post('calendar/approve', [CalendarController::class, 'approve'])->name('calendar/approve')->middleware('auth');
    Route::post('calendar/disapprove', [CalendarController::class, 'disapprove'])->name('calendar/disapprove')->middleware('auth');

    Route::get('auth/login', [AuthController::class, 'login'])->name('auth/login');
    Route::post('auth/login', [AuthController::class, 'authenticate'])->name('auth/authenticate')->middleware('throttle:auth');
    Route::get('auth/register', [AuthController::class, 'register'])->name('auth/register');
    Route::post('auth/register', [AuthController::class, 'store'])->name('auth/store')->middleware('throttle:auth');
    Route::get('auth/forgot', [AuthController::class, 'forgot'])->name('auth/forgot');
    Route::post('auth/forgot', [AuthController::class, 'do_forgot'])->name('auth/do_forgot')->middleware('throttle:auth');
    Route::get('auth/forgot_process', [AuthController::class, 'forgot_process'])->name('forgot_process');
    Route::post('auth/forgot_success', [AuthController::class, 'forgot_success'])->name('forgot_success')->middleware('throttle:auth');
    Route::get('auth/activation', [AuthController::class, 'activation'])->name('auth/activation');
    Route::get('auth/activation_send', [AuthController::class, 'activation_send'])->name('auth/activation_send');
    Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth/logout');

    Route::get('prices', [PriceController::class, 'index'])->name('prices')->middleware('auth');
    Route::get('prices/load_new', [PriceController::class, 'load_new'])->name('prices/load_new')->middleware('auth');
    Route::get('prices/load_exists/{id}', [PriceController::class, 'load_exists'])->name('prices/load_exists');
    Route::post('prices/store', [PriceController::class, 'store'])->name('prices/store')->middleware('auth', 'throttle:auth');
    Route::post('prices/update', [PriceController::class, 'update'])->name('prices/update')->middleware('auth', 'throttle:auth');
    Route::delete('prices/delete', [PriceController::class, 'delete'])->name('prices/delete')->middleware('auth', 'throttle:auth');
    Route::post('prices/text', [PriceController::class, 'text_store'])->name('prices/text_store')->middleware('auth', 'throttle:auth');
    Route::get('prices/text/{id}', [PriceController::class, 'text'])->name('prices/text')->middleware('auth');

    Route::get('locations', [LocationController::class, 'index'])->name('locations')->middleware('auth');
    Route::get('locations/load_new', [LocationController::class, 'load_new'])->name('locations/load_new')->middleware('auth');
    Route::get('locations/load_exists/{id}', [LocationController::class, 'load_exists'])->name('locations/load_exists');
    Route::post('locations/store', [LocationController::class, 'store'])->name('locations/store')->middleware('auth', 'throttle:auth');
    Route::delete('locations/delete', [LocationController::class, 'delete'])->name('locations/delete')->middleware('auth', 'throttle:auth');

    Route::get('cart', [CartController::class, 'index'])->name('cart/index')->middleware('auth');
    Route::post('cart/add', [CartController::class, 'add'])->name('cart/add')->middleware('auth');
    Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart/remove')->middleware('auth');
    Route::post('payment/notify', [CartController::class, 'payment_notify'])->name('payment/notify');
    Route::get('payment/success', [CartController::class, 'payment_success'])->name('payment/success');
    Route::get('payment/error', [CartController::class, 'payment_error'])->name('payment/error');

    Route::get('town/search', [TownController::class, 'search'])->name('town/search');
    Route::get('level/search', [LevelController::class, 'search'])->name('level/search');

    Route::get('ozel-ders-ilanlari-verenler/{id}/{id2}', [UserController::class, 'search'])->name('users/search');
    Route::get('ozel-ders-ilanlari-verenler/{id}', [UserController::class, 'search'])->name('users/search');
    Route::get('ozel-ders-ilanlari-verenler', [UserController::class, 'search'])->name('users/search');
    Route::get('users/search', [UserController::class, 'search'])->name('users/search');
    Route::get('users/required', [UserController::class, 'required'])->name('users/required');
    Route::get('users/review', [UserController::class, 'review'])->name('users/review');
    Route::get('users/dashboard', [UserController::class, 'dashboard'])->name('users/dashboard')->middleware('auth');
    Route::get('users/personal', [UserController::class, 'personal'])->name('users/personal')->middleware('auth');
    Route::post('users/personal', [UserController::class, 'personal_save'])->name('users/personal_save')->middleware('auth', 'throttle:auth');
    Route::get('users/delete_photo', [UserController::class, 'delete_photo'])->name('users/delete_photo')->middleware('auth');
    Route::get('users/informations', [UserController::class, 'informations'])->name('users/informations')->middleware('auth');
    Route::post('users/informations', [UserController::class, 'informations_save'])->name('users/informations_save')->middleware('auth');
    Route::get('users/preferences', [UserController::class, 'preferences'])->name('users/preferences')->middleware('auth');
    Route::post('users/preferences', [UserController::class, 'preferences_save'])->name('users/preferences_save')->middleware('auth');
    Route::get('users/discounts', [UserController::class, 'discounts'])->name('users/discounts')->middleware('auth');
    Route::post('users/discounts', [UserController::class, 'discounts_save'])->name('users/discounts_save')->middleware('auth');
    Route::get('users/memberships', [UserController::class, 'memberships'])->name('users/memberships')->middleware('auth');
    Route::get('users/new_message', [UserController::class, 'new_message'])->name('users/new_message')->middleware('auth');
    Route::get('users/new_comment', [UserController::class, 'new_comment'])->name('users/new_comment')->middleware('auth');
    Route::get('users/new_complaint', [UserController::class, 'new_complaint'])->name('users/new_complaint');
    Route::post('users/send_message', [UserController::class, 'send_message'])->name('users/send_message')->middleware('auth', 'throttle:auth');
    Route::post('users/send_comment', [UserController::class, 'send_comment'])->name('users/send_comment')->middleware('auth', 'throttle:auth');
    Route::post('users/send_complaint', [UserController::class, 'send_complaint'])->name('users/send_complaint')->middleware('throttle:auth');
    Route::post('users/mobile_phone', [UserController::class, 'mobile_phone'])->name('users/mobile_phone')->middleware('throttle:auth');
    Route::get('users/activities', [UserController::class, 'activities'])->name('users/activities')->middleware('auth');
    Route::any('users/cancellation', [UserController::class, 'cancellation'])->name('users/cancellation')->middleware('auth');
    Route::get('upload/badge', [UserController::class, 'badge'])->name('users/badge')->middleware('auth');
    Route::post('upload/badge', [UserController::class, 'badge_save'])->name('users/badge_save')->middleware('auth');
    Route::get('domain', [UserController::class, 'domain'])->name('domain')->middleware('auth');
    Route::post('domain/check', [UserController::class, 'domain_check'])->name('domain_check')->middleware('auth');
    Route::post('domain/select', [UserController::class, 'domain_select'])->name('domain_select')->middleware('auth');
    Route::get('users/expired_30', [UserController::class, 'expired_30'])->name('users/expired_30');

    Route::get('contents', [ContentController::class, 'index'])->name('contents/index')->middleware('auth');
    Route::get('contents/load/{id}', [ContentController::class, 'load'])->name('contents/load');
    Route::get('contents/add', [ContentController::class, 'add'])->name('contents/add')->middleware('auth');
    Route::get('contents/edit/{id}', [ContentController::class, 'edit'])->name('contents/edit')->middleware('auth');
    Route::post('contents/save', [ContentController::class, 'save'])->name('contents/save')->middleware('auth');
    Route::get('contents/delete/{id}', [ContentController::class, 'delete'])->name('contents/delete')->middleware('auth');
    Route::get('contact', [ContentController::class, 'contact'])->name('contents/contact');
    Route::post('contact', [ContentController::class, 'contact'])->name('contents/contact2');

    Route::get('chat', [ChatController::class, 'index'])->name('chat/index')->middleware('auth');
    Route::get('chat/persons', [ChatController::class, 'persons'])->name('chat/persons')->middleware('auth');
    Route::get('chat/detail/{id}', [ChatController::class, 'detail'])->name('chat/detail')->middleware('auth');
    Route::post('chat/send', [ChatController::class, 'send'])->name('chat/send')->middleware('auth');
    Route::get('chat/delete_conversation', [ChatController::class, 'delete_conversation'])->name('chat/delete_conversation')->middleware('auth');
    Route::get('chat/block_conversation', [ChatController::class, 'block_conversation'])->name('chat/block_conversation')->middleware('auth');

    Route::get('email/change', function(){
        return view('auth.email_change');
    })->name('email/change')->middleware('auth');
    Route::post('email/change', [AuthController::class, 'email_changing'])->name('email/changing')->middleware('auth');
    Route::post('activation/resend', [AuthController::class, 'resend_activation'])->name('activation/resend')->middleware('auth');

    Route::get('username/change', function(){
        return view('auth.username_change');
    })->name('username/change')->middleware('auth');
    Route::post('username/change', [AuthController::class, 'username_changing'])->name('username/changing')->middleware('auth');

    Route::get('password/change', function(){
        return view('auth.password_change');
    })->name('password/change')->middleware('auth');
    Route::post('password/change', [AuthController::class, 'password_changing'])->name('password/changing')->middleware('auth');

    Route::any('uploads/{any?}', function ($any = null) {
        return Redirect::to($any, 301);
    })->where('any', '.*');

    Route::get('{all?}', [RouteController::class, 'index'])->where('all', '(.*)')->name('dynamic');
}


});
