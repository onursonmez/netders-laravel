<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Calendar_definition;
use App\Models\Calendar_exception;
use App\Models\Calendar_lesson;
use App\Models\User;
use Lang;
use Str;

/*
 * Canlı ders durumları ve açıklamaları
 * W: Waiting: Ders sepete eklendi
 * P: Payed: ödeme yapıldı, PayTR notify bekleniyor
 * A: Active: PayTR ödeme notify success, ders aktif ve günü gelmeden değiştirilebilir
 * D: Declined: öğrenci aldığı dersi beğenmedi. Cron ile PayTR iade prosesi bekleniyor
 * R: Refund: Ücret iadesi yapıldı. Başarısız olarak tamamlandı
 * C: Completed: Öğrenci derse onay verdi. Cron ile PayTR pazaryeri para dagitimi bekleniyor
 * F: Finished: Ücret dağıtıldı. Başarılı olarak tamamlandı
 */

class CalendarController extends Controller
{
    public function get()
    {
        $this->data['definition'] = Calendar_definition::where('user_id', Auth::user()->id)->first();

        $begin = new DateTime("00:00");
        $end   = new DateTime("24:00");
        $interval = DateInterval::createFromDateString('15 min');
        $this->data['times'] = new DatePeriod($begin, $interval, $end);
        $this->data['exceptions'] = Calendar_exception::where('user_id', Auth::user()->id)->get();

        return view('calendar.get', $this->data);
    }

    public function change($lesson_id)
    {
        $begin = new DateTime("00:00");
        $end   = new DateTime("24:00");
        $interval = DateInterval::createFromDateString('15 min');
        $times = new DatePeriod($begin, $interval, $end);

        $lesson = Calendar_lesson::where('student_id', Auth::user()->id)->where('id', $lesson_id)->first();
        if(empty($lesson)) return false;

        $returnHTML = view('calendar.change')->with('times', $times)->with('lesson', $lesson)->render();

        return response()->json(['success' => true, 'html'=> $returnHTML]);  
    }

    public function change_save(Request $request)
    {
        $validate_data = $request->validate([
            'date'     => 'required',
            'time'     => 'required',
            'lesson_id'     => 'required',
        ]);    
        
        $is_exist = Calendar_lesson::where('student_id', Auth::user()->id)->where('id', $request->get('lesson_id'))->first();
        if(!empty($is_exist))
        {
            $data = new Request([
                'user_id'   => $is_exist->teacher_id,
                'date'  => \Carbon\Carbon::parse($request->get('date') . $request->get('time'), Auth::user()->timezone->code)->setTimezone('UTC'),
                'lesson_minute' => $is_exist->duration,
                'student_id' => Auth::user()->id
            ]);
            $response = $this->check($data);
            
            if($response)
            {
                $is_exist->start_at = \Carbon\Carbon::parse($request->get('date') . $request->get('time'), Auth::user()->timezone->code)->setTimezone('UTC');
                $is_exist->end_at = \Carbon\Carbon::parse($request->get('date') . $request->get('time'), Auth::user()->timezone->code)->addMinutes($is_exist->duration)->setTimezone('UTC');
                $is_exist->save();
                
                return $request->wantsJson()
                            ? response()->json(['success' => [Lang::get('auth.completed')]])
                            : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);                  
            }
        }

        return $request->wantsJson()
                    ? response()->json(['errors' => [Lang::get('calendar.selected_date_is_exist')]], 422)
                    : redirect()->back()->withErrors(['errors' => [Lang::get('calendar.selected_date_is_exist')]]);                 
    }

    public function set(Request $request)
    {
        $validate_data = $request->validate([
            'lesson_min_minute'     => 'required',
            'lesson_max_minute'     => 'required',
            'aggrement'     => 'required',
        ]);              

        $definition = Calendar_definition::where('user_id', Auth::user()->id)->first();
        if(empty($definition))
        {
            $definition = new Calendar_definition;
        }

        $definition->user_id = Auth::user()->id;
        $definition->d1_from = $request->get('d1_from') ? \Carbon\Carbon::parse($request->get('d1_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d1_to = $request->get('d1_to') ? \Carbon\Carbon::parse($request->get('d1_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d2_from = $request->get('d2_from') ? \Carbon\Carbon::parse($request->get('d2_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d2_to = $request->get('d2_to') ? \Carbon\Carbon::parse($request->get('d2_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d3_from = $request->get('d3_from') ? \Carbon\Carbon::parse($request->get('d3_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d3_to = $request->get('d3_to') ? \Carbon\Carbon::parse($request->get('d3_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d4_from = $request->get('d4_from') ? \Carbon\Carbon::parse($request->get('d4_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d4_to = $request->get('d4_to') ? \Carbon\Carbon::parse($request->get('d4_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d5_from = $request->get('d5_from') ? \Carbon\Carbon::parse($request->get('d5_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d5_to = $request->get('d5_to') ? \Carbon\Carbon::parse($request->get('d5_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d6_from = $request->get('d6_from') ? \Carbon\Carbon::parse($request->get('d6_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d6_to = $request->get('d6_to') ? \Carbon\Carbon::parse($request->get('d6_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d7_from = $request->get('d7_from') ? \Carbon\Carbon::parse($request->get('d7_from'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->d7_to = $request->get('d7_to') ? \Carbon\Carbon::parse($request->get('d7_to'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:iP') : null;
        $definition->lesson_min_minute = $request->get('lesson_min_minute') ?? null;
        $definition->lesson_max_minute = $request->get('lesson_max_minute') ?? null;
        $definition->save();

        return $request->wantsJson()
                    ? response()->json(['success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);  
    }    

    public function add(Request $request)
    {
        $validate_data = $request->validate([
            'user_id' => 'required',
            'date' => 'required',
            'lesson_id' => 'required',
            'lesson_minute' => 'required',
        ]);

        if($this->check($request))
        {
            $definition = Calendar_definition::where('user_id', $request->get('user_id'))->first();
            if(!empty($definition))
            {
                $price = \App\Models\Price::where('user_id', $request->get('user_id'))->where('id', $request->get('lesson_id'))->first();
                if(!empty($price) && !empty($price->price_live))
                {
                    $price = $price->price_live / 60;
                    $price = $price * $request->get('lesson_minute');
                    
                    $local_start_date = \Carbon\Carbon::parse($request->get('date'))->format('Y-m-d H:i');
                    $local_end_date = \Carbon\Carbon::parse($request->get('date'))->addMinutes($request->get('lesson_minute'))->format('Y-m-d H:i');
                    
                    $utc_start_date = \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->format('Y-m-d H:i');
                    $utc_end_date = \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->addMinutes($request->get('lesson_minute'))->format('Y-m-d H:i');

                    $teacher = User::findOrFail($request->get('user_id'));

                    $jwt_teacher = \Firebase\JWT\JWT::encode([
                        'context' => [
                            'user' => [
                                'name' => $teacher->first_name . ' ' . $teacher->last_name,
                                'email' => $teacher->email
                            ]
                        ],
                        'aud' => 'jitsi',
                        'iss' => 'netders',
                        'sub' => 'school.netders.com',
                        'room' => md5($request->get('user_id').'-'.Auth::user()->id),
                        'exp' => strtotime('+30 minutes', strtotime($local_end_date)),
                        'moderator' => true
                    ], env('JWT_SECRET'));

                    $jwt_student = \Firebase\JWT\JWT::encode([
                        'context' => [
                            'user' => [
                                'name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                                'email' => Auth::user()->email
                            ]
                        ],
                        'aud' => 'jitsi',
                        'iss' => 'netders',
                        'sub' => 'school.netders.com',
                        'room' => md5($request->get('user_id').'-'.Auth::user()->id),
                        'exp' => strtotime('+30 minutes', strtotime($local_end_date)),
                        'moderator' => false
                    ], env('JWT_SECRET'));                    

                    $teacher = User::findOrFail($request->get('user_id'));
                    $lesson = new Calendar_lesson;
                    $lesson->start_at = $utc_start_date;
                    $lesson->end_at = $utc_end_date;
                    $lesson->student_id = Auth::user()->id;
                    $lesson->teacher_id = $request->get('user_id');
                    $lesson->room_password = null;
                    $lesson->topic = $teacher->first_name . ' - ' . Auth::user()->first_name;
                    $lesson->teacher_login_password = $jwt_teacher;
                    $lesson->student_login_password = $jwt_student;
                    $lesson->teacher_link = 'https://school.netders.com/' . $teacher->id . '000' . Auth::user()->id . '/?jwt=' .$jwt_teacher;
                    $lesson->student_link = 'https://school.netders.com/' . $teacher->id . '000' . Auth::user()->id . '/?jwt=' .$jwt_student;
                    $lesson->duration = $request->get('lesson_minute');
                    $lesson->price = $price;
                    $lesson->save();
                    $lesson_id = $lesson->id;

                    $data = new Request([
                        'price'   => $price,
                        'product_id'  => 14,
                        'related_id' => $lesson_id
                    ]);
                    $cartController = new \App\Http\Controllers\CartController;
                    $cartController->add($data);
 
                    return response()->json(['success' => true, 'message' => Lang::get('cart.lesson_added'), 'start_date' => $local_start_date, 'end_date' => $local_end_date]);
                }
            }
        }
    }

    public function check(Request $request)
    {
        $validate_data = $request->validate([
            'user_id' => 'required',
            'date' => 'required',
            'lesson_minute' => 'required',
        ]);
        
        $day_number = \Carbon\Carbon::parse($request->get('date'))->dayOfWeek;
        $days = [0 => 7, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6];
        $day_number = $days[$day_number];
        if(!empty($day_number))
        {
            $d_from = 'd'.$day_number.'_from';
            $d_to = 'd'.$day_number.'_to';
            $is_not_null = Calendar_definition::where('user_id', $request->get('user_id'))->whereNotNull($d_from)->whereNotNull($d_to)->count();
            if($is_not_null > 0)
            {
                $from_hour = \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->format('H:i');
                $to_hour = \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->addMinutes($request->get('lesson_minute'))->format('H:i');
                
                $is_allowed = Calendar_definition::where('user_id', $request->get('user_id'))->whereTime($d_from, '<=', $from_hour)->whereTime($d_to, '>=', $to_hour)->count();

                
                if($is_allowed > 0 && \Carbon\Carbon::parse($request->get('date')) <= \Carbon\Carbon::now('UTC')->setTimezone(Auth::user()->timezone->code)->add(1, 'week'))
                {
                    $is_available = Calendar_lesson::where('teacher_id', $request->get('user_id'))
                    ->where(function($q) use($request)
                    {
                        if($request->get('student_id'))
                        {
                            $q->where('student_id', '!=', $request->get('student_id'));
                        }
                    })
                    ->where(function($q) use($request)
                    {
                        $q->where('start_at', '<=', \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->format('Y-m-d H:i'))
                        ->where('end_at', '>', \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->format('Y-m-d H:i'));
                    })->orWhere(function($q) use($request)
                    {
                        $q->where('start_at', '<', \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->addMinutes($request->get('lesson_minute'))->setTimezone('UTC')->format('Y-m-d H:i'))
                        ->where('end_at', '>', \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->addMinutes($request->get('lesson_minute'))->setTimezone('UTC')->format('Y-m-d H:i'));
                    })->orWhere(function($q) use($request)
                    {
                        $q->where('start_at', '>', \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->setTimezone('UTC')->format('Y-m-d H:i'))
                        ->where('end_at', '<', \Carbon\Carbon::parse($request->get('date'), Auth::user()->timezone->code)->addMinutes($request->get('lesson_minute'))->setTimezone('UTC')->format('Y-m-d H:i'));
                    })                    
                    ->count();
                    
                    if($is_available == 0)
                    return $request->wantsJson()
                                ? response()->json(['success' => true])
                                : true;
                }
            }
        }

        return $request->wantsJson()
                    ? response()->json(['success' => false])
                    : false;
    }    

    public function load_lessons(Request $request)
    {
        $validate_data = $request->validate([
            'user_id' => 'required',
        ]);              
        $prices = \App\Models\Price::where('user_id', $request->get('user_id'))->with('subject')->with('level')->get();
        $definition = Calendar_definition::where('user_id', $request->get('user_id'))->first();

        $returnHTML = view('calendar.load_lessons')->with('prices', $prices)->with('definition', $definition)->with('lesson_id', $request->get('previous_lesson_id'))->with('lesson_minute', $request->get('previous_lesson_minute'))->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);  
    }     
    
    public function exception_store(Request $request)
    {
        $validate_data = $request->validate([
            'from_date' => 'required',
            'from_time' => 'required',
            'to_date' => 'required',
            'to_time' => 'required',            
        ]);

        $exception = new Calendar_exception;
        $exception->user_id = Auth::user()->id;
        $exception->from_date = \Carbon\Carbon::parse($request->get('from_date') . ' ' . $request->get('from_time'), Auth::user()->timezone->code)->setTimezone('UTC');
        $exception->to_date = \Carbon\Carbon::parse($request->get('to_date') . ' ' . $request->get('to_time'), Auth::user()->timezone->code)->setTimezone('UTC');
        $exception->save();

        return redirect('calendar/get')->with(['messages' => [Lang::get('auth.completed')]]);
    }

    public function exception_delete($id)
    {
        Calendar_exception::where('id', $id)->where('user_id', Auth::user()->id)->delete();

        return redirect('calendar/get')->with(['messages' => [Lang::get('auth.completed')]]);
    }    

    public function lessons()
    {
        $lessons = Calendar_lesson::where(function($q){
            if(Auth::user()->group_id != 1)
            $q->where('student_id', Auth::user()->id)->orWhere('teacher_id', Auth::user()->id);
        })->orderBy('start_at', 'desc')->get();

        $this->data['lessons'] = $lessons;
        
        return view('calendar.lessons', $this->data);        
    }

    public function approve(Request $request)
    {
        $request->validate([
            'rating' => 'required',
            'comment' => 'required',
            'data_id' => 'required',
        ]);

        $lesson = Calendar_lesson::where('student_id', Auth::user()->id)->where('id', $request->get('data_id'))->where('status', 'A')->first();
        if(!empty($lesson))
        {
            $lesson->status = 'C'; //completed
            $lesson->save();

            $comment = new \App\Models\Comment;
            $comment->user_id = $lesson->teacher_id;
            $comment->creator_id = Auth::user()->id;
            $comment->comment = $request->get('comment');
            $comment->rating = $request->get('rating');
            $comment->save();

            //PayTR pazaryeri bekleyen odemeyi egitmene ve netders'e gonder
        }

        return $request->wantsJson()
                    ? response()->json(['redirect' => url('calendar/lessons'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);           
    }

    public function disapprove(Request $request)
    {
        $request->validate([
            'rating' => 'required',
            'comment' => 'required',
            'data_id' => 'required',
        ]);

        $lesson = Calendar_lesson::where('student_id', Auth::user()->id)->where('id', $request->get('data_id'))->where('status', 'A')->first();

        if(!empty($lesson))
        {
            $lesson->status = 'D'; //disapproved
            $lesson->save();

            $comment = new \App\Models\Comment;
            $comment->user_id = $lesson->teacher_id;
            $comment->creator_id = Auth::user()->id;
            $comment->comment = $request->get('comment');
            $comment->rating = $request->get('rating');
            $comment->save();            

            //PayTR pazaryeri bekleyen ogrenciye iade et
        }

        return $request->wantsJson()
                    ? response()->json(['redirect' => url('calendar/lessons'), 'success' => [Lang::get('auth.completed')]])
                    : redirect()->back()->with(['messages' => [Lang::get('auth.completed')]]);      
    } 
}
