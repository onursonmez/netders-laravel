<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Sluggable, HasRoles;

    public $token;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'status',
        'online',
        'search_point',
        'timezone_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getToken()
    {
        return $this->token;
    }

    public function sluggable(): array
    {
        return [
            'username' => [
                'source' => 'username'
            ]
        ];
    }       

    public function timezone()
    {
        return $this->hasOne(\App\Models\Timezone::class, 'id', 'timezone_id');
    }

    public function is_teacher()
    {
        return in_array(Auth::user()->group_id, [3,4,5]) ? true : false;
    }    

    public function email_verified()
    {
        return $this->belongsTo(\App\Models\Verified_email::class, 'id', 'user_id');
    }   

    public function pending_photos()
    {
        return $this->hasOne(\App\Models\Photo::class)->where('approved', false);
    }

    public function photo()
    {
        return $this->hasOne(\App\Models\Photo::class)->where('approved', true);
    }

    public function has_photo()
    {
        return $this->hasOne(\App\Models\Photo::class)->where('approved', true);
    }    

    public function delete_all_pending_photos()
    {
        foreach($this->hasMany(\App\Models\Photo::class)->where('approved', false)->get() as $pending_photo)
        {
            if(unlink(public_path($pending_photo->url)))
            {
                $pending_photo->delete();
            }
        }
    }

    public function conversations() 
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants', 'user_id', 'conversation_id')->orderBy('updated_at', 'desc')->limit(100);
    }  

    public function prices()
    {
        return $this->hasMany(\App\Models\Price::class)->with(['subject', 'level']);
    }

    public function lessons()
    {
        return $this->hasMany(\App\Models\Calendar_lesson::class, 'teacher_id', 'id');
    }
    
    public function locations()
    {
        return $this->hasMany(\App\Models\Location::class);
    }     

    public function detail()
    {
        return $this->hasOne(\App\Models\User_detail::class);
    }

    public function user_figures()
    {
        return $this->hasMany(\App\Models\User_figure::class);
    }      
    
    public function user_places()
    {
        return $this->hasMany(\App\Models\User_place::class);
    }          
    
    public function user_times()
    {
        return $this->hasMany(\App\Models\User_time::class);
    }              

    public function user_services()
    {
        return $this->hasMany(\App\Models\User_service::class);
    }                  

    public function user_genders()
    {
        return $this->hasMany(\App\Models\User_gender::class);
    }                      

    public function user_discounts()
    {
        return $this->hasMany(\App\Models\User_discount::class);
    }   
    
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->where('status', 'A');
    }    
    
    public function membership_expire()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('expired', false)->whereIn('product_id', [1,2,3,4,5,6,7,8])->orderBy('created_at', 'desc')->first();
    }            

    public function service_badge()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('product_id', 10);
    }
    
    public function featured()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('expired', false)->where('product_id', 9)->orderBy('end_at', 'desc')->first();
    }

    public function domain($status = null)
    {
        if(empty($status))
            return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('expired', false)->where('product_id', 11)->orderBy('end_at', 'desc')->first();
        else
            return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('status', $status)->where('expired', false)->where('product_id', 11)->orderBy('end_at', 'desc')->first();
    }    

    public function home()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('expired', false)->where('product_id', 12)->orderBy('end_at', 'desc')->first();
    }

    public function ad()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id', 'user_id')->where('product_id', 13)->orderBy('end_at', 'desc')->first();
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }        

    public function required()
    {
        $required = [];

        if(!Auth::user()->detail->birthday)
        $required[] = array(url('users/personal'), 'Kişisel Bilgiler > Doğum Tarihin');
    
        if(!Auth::user()->detail->gender)
        $required[] = array(url('users/personal'), 'Kişisel Bilgiler > Cinsiyetin');
    
        if(!Auth::user()->detail->phone_mobile)
        $required[] = array(url('users/personal'), 'Kişisel Bilgiler > Cep Telefonu Numaran');
    
        if(!Auth::user()->detail->city_id)
        $required[] = array(url('users/personal'), 'Kişisel Bilgiler > Bulunduğun Şehir');
    
        if(!Auth::user()->detail->town_id)
        $required[] = array(url('users/personal'), 'Kişisel Bilgiler > Bulunduğun İlçe');
    
        if(!Auth::user()->detail->title)
        $required[] = array(url('users/informations'), 'Tanıtım Yazıları > Başlık');
    
        if(!Auth::user()->detail->long_text)
        $required[] = array(url('users/informations'), 'Tanıtım Yazıları > Detaylı Tanıtım Metni');
    
        if(Auth::user()->prices->count() == 0)
        $required[] = array(url('prices'), 'Ders Ücretleri > Yeni Ders Ücreti');
    
        if(Auth::user()->locations->count() == 0)
        $required[] = array(url('locations'), 'Ders Verilen Bölgeler > Yeni Ders Verilen Bölge');
        
        return $required;
    }

    public static function calculate_search_point($user_id)
    {
        $user = User::findOrFail($user_id);

        $point = 0;

        if($user->group_id == 5)
        {
            $point += 500;
        }

        if($user->group_id == 4)
        {
            $point += 150;
        }

        if($user->group_id == 3)
        {
            $point += 1;
        }

        $oneCikanlar = \App\Models\Order::where('product_id', 9)->where('user_id', $user_id)->where('end_at', '>', \Carbon\Carbon::now())->count();
        if($oneCikanlar > 0)
        {
            $point += 100;
        }

        $uzmanEgitmenler = \App\Models\Order::where('product_id', 10)->where('user_id', $user_id)->where('end_at', '>', \Carbon\Carbon::now())->count();
        if($uzmanEgitmenler > 0)
        {
            $point += 1;
        }        

        $ucretsizIlkDers = \App\Models\User_discount::where('discount_id', 1)->where('user_id', $user_id)->count();
        if($ucretsizIlkDers > 0)
        {
            $point += 1;
        }

        $uyeOgrenci = \App\Models\User_discount::where('discount_id', 2)->where('user_id', $user_id)->count();
        if($uyeOgrenci > 0)
        {
            $point += 1;
        }        

        User::where('id', $user_id)->update(['search_point' => $point]);
    }

    public static function rank($user)
    {
        $rank = \DB::select('SELECT
        *
        FROM (
            SELECT
                t.id,
                ROW_NUMBER() OVER (ORDER BY t.highScore DESC) AS rank
            FROM (
                SELECT
                    id,
                    MAX(search_point) AS highScore
                FROM users
                WHERE group_id IN(3,4,5) and search_point is not null
                GROUP BY id
            ) AS t
        ) AS rt
        WHERE
        rt.id = ?', [$user->id]);     
        
        return !empty($rank) && $rank[0]->rank > 0 ? $rank[0]->rank : 'Belirsiz';
    }
}
