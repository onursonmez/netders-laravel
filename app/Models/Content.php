<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;
use Session;

class Content extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title'],
            ]
        ];
    }    

    public function category()
    {
        return $this->hasOne(\App\Models\Content_category::class);
    }    

    public static function menu()
    {
        $response = [];

        if(Auth::check())
        {
            if(Auth::user()->hasRole('admin'))
            {
                $response[10] = ['url' => url('cp'), 'text' => 'Kontrol Paneli'];
                $response[20] = ['url' => url('cp/photo_approval'), 'text' => 'Onay Bekleyen Fotoğraflar'];
                $response[30] = ['url' => url('cp/user_approval'), 'text' => 'Onay Bekleyen Profiller'];
                $response[40] = ['url' => url('cp/badge_approval'), 'text' => 'Onay Bekleyen Rozetler'];
                $response[50] = ['url' => url('cp/domain_approval'), 'text' => 'Onay Bekleyen Domainler'];
                $response[60] = ['url' => url('cp/ad_approval'), 'text' => 'Onay Bekleyen Reklamlar'];
                $response[60] = ['url' => url('cp/prices_text_approval'), 'text' => 'Onay Bekleyen Tanıtım Yazıları'];
                $response[70] = ['url' => url('cp/orders'), 'text' => 'Siparişler'];
                $response[80] = ['url' => url('cp/messages'), 'text' => 'Mesajlar'];
                $response[90] = ['url' => url('cp/lessons'), 'text' => 'Canlı Dersler'];
            }
            else            
            {
                $response[10] = ['url' => url('users/dashboard'), 'text' => 'Kontrol Paneli'];        
                $response[20] = ['url' => url('users/personal'), 'text' => 'Kişisel Bilgiler'];
                $response[100] = ['url' => url('calendar/lessons'), 'text' => 'Canlı Ders Hareketleri'];
                $response[110] = ['url' => url('chat'), 'text' => 'Mesajlar'];
                $response[210] = ['url' => url('email/change'), 'text' => 'E-posta Değiştir'];
                $response[220] = ['url' => url('password/change'), 'text' => 'Şifre Değiştir'];
                $response[230] = ['url' => url('users/cancellation'), 'text' => 'Üyelik İptali'];

                if(Auth::user()->is_teacher())
                {
                    $response[15] = ['url' => url('cart'), 'text' => 'Alışveriş Sepeti'];
                    $response[30] = ['url' => url('users/informations'), 'text' => 'Tanıtım Yazıları'];
                    $response[40] = ['url' => url('users/preferences'), 'text' => 'Tercihler'];
                    $response[50] = ['url' => url('prices'), 'text' => 'Ders Ücretleri'];
                    $response[70] = ['url' => url('locations'), 'text' => 'Ders Verilen Bölgeler'];
                    $response[80] = ['url' => url('users/discounts'), 'text' => 'İndirim Tanımlamaları'];
                    $response[200] = ['url' => url('username/change'), 'text' => 'Kullanıcı Adı Değiştir'];
                    if(Auth::user()->status == 'A')
                    {
                        $response[120] = ['url' => url('users/memberships'), 'text' => 'Üyelik Durumu'];
                        $response[130] = ['url' => url('users/activities'), 'text' => 'Hesap Hareketleri'];
                        $response[90] = ['url' => url('calendar/get'), 'text' => 'Canlı Ders Takvimi'];
                    }
                }
            }
            $response[240] = ['url' => url('auth/logout'), 'text' => 'Güvenli çıkış'];
        }
        else
        {
            $response[10] = ['url' => url('/'), 'text' => 'Ana Sayfa'];
            $response[20] = ['url' => url('auth/login'), 'text' => 'Giriş'];
            $response[30] = ['url' => url('auth/register'), 'text' => 'Ücretsiz üye ol'];
            $response[40] = ['url' => url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')), 'text' => 'Eğitmen ara'];
            $response[50] = ['url' => url('netders/nasil-calisir.html'), 'text' => 'Nasıl ç ır?'];
            $response[60] = ['url' => url('yardim'), 'text' => 'Yardım'];
            $response[70] = ['url' => url('contact'), 'text' => 'İletişim'];  
        }

        ksort($response);

        return $response;
    }
}
