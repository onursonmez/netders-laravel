<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Cviebrock\EloquentSluggable\Services\SlugService;

use App\Models\User;

class UpdateSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');

        /*
        $items = DB::connection('mysql')->select('SELECT * FROM core_users where email is not null and firstname is not null and lastname is not null AND id > 21229 order by id asc');
        foreach($items as $item)
        {
            $user_id = DB::table('users')->insertGetId(
                [
                    'old_id' => $item->id, 
                    'created_at' => date('Y-m-d H:i:s', $item->joined),
                    'email_verified_at' => date('Y-m-d H:i:s', $item->joined),
                    'updated_at' => date('Y-m-d H:i:s', $item->joined),                    
                    'group_id' => $item->ugroup, 
                    'first_name' => $item->firstname,
                    'last_name' => $item->lastname,
                    'email' => $item->email,
                    'username' => SlugService::createSlug(User::class, 'username', $item->username),
                    'password' => $item->password ? $item->password : md5(time()),
                    'status' => $item->status,
                    'online' => false,
                    'search_point' => $item->search_point,
                    'timezone_id' => 16,
                ]
            );

            $city = \App\Models\City::where('old_id', $item->city)->first();
            $town = \App\Models\Town::where('old_id', $item->town)->first();
            
            DB::table('user_details')->insertGetId(
                [
                    'user_id' => $user_id,
                    'phone_mobile' => $item->mobile,
                    'birthday' => $item->birthday ? date('d.m.Y', strtotime(str_replace('/', '.', str_replace('-', '.', str_replace('_', '.', str_replace(' ', '', trim($item->birthday))))))) : null,
                    'city_id' => $city->id ?? null,
                    'town_id' => $town->id ?? null,
                    'gender' => $item->gender,
                    'profession_id' => $item->profession,
                    'title' => $item->text_title,
                    'long_text' => $item->text_long,
                    'reference_text' => $item->text_reference,
                    'company_title' => substr($item->company_name, 0, 100),
                    'privacy_lastname' => $item->privacy_lastname == 1 ? 1 : 2,
                    'privacy_phone' => $item->privacy_phone == 1 ? 1 : 2
                ]
            );            

            if($item->username_old)
            {
                DB::table('usernames')->insert(
                    [
                        'user_id' => $user_id, 
                        'username' => $item->username_old, 
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );                
            }
            
            if($item->ugroup == 3 || $item->ugroup == 4 || $item->ugroup == 5)
            {
                
                      

                if(!empty($item->figures)){
                    foreach(explode(',',$item->figures) as $i){
                        DB::table('user_figures')->insert([
                            'user_id' => $user_id, 
                            'figure_id' => $i, 
                            'created_at' => date('Y-m-d H:i:s')
                        ]);                          
                    }
                }

                if(!empty($item->places)){
                    foreach(explode(',',$item->places) as $i){
                        DB::table('user_places')->insert([
                            'user_id' => $user_id, 
                            'place_id' => $i, 
                            'created_at' => date('Y-m-d H:i:s')
                        ]);                          
                    }
                }

                if(!empty($item->times)){
                    foreach(explode(',',$item->times) as $i){
                        DB::table('user_times')->insert([
                            'user_id' => $user_id, 
                            'time_id' => $i, 
                            'created_at' => date('Y-m-d H:i:s')
                        ]);                          
                    }
                }       
                
                if(!empty($item->services)){
                    foreach(explode(',',$item->services) as $i){
                        DB::table('user_services')->insert([
                            'user_id' => $user_id, 
                            'service_id' => $i, 
                            'created_at' => date('Y-m-d H:i:s')
                        ]);                          
                    }
                }  
                
                if(!empty($item->genders)){
                    foreach(explode(',',$item->genders) as $i){
                        DB::table('user_genders')->insert([
                            'user_id' => $user_id, 
                            'gender_id' => $i, 
                            'created_at' => date('Y-m-d H:i:s')
                        ]);                          
                    }
                }                  

                if(!empty($item->discount7)){
                    DB::table('user_discounts')->insert([
                        'user_id' => $user_id, 
                        'discount_id' => 1, 
                        'description' => null,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);                          
                }

                if(!empty($item->discount10)){
                    DB::table('user_discounts')->insert([
                        'user_id' => $user_id, 
                        'discount_id' => 2, 
                        'rate' => $item->discount10,
                        'description' => null,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);                           
                }       
                
                if(!empty($item->discount9)){
                    DB::table('user_discounts')->insert([
                        'user_id' => $user_id, 
                        'discount_id' => 3, 
                        'rate' => $item->discount9,
                        'description' => null,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);                        
                }

                if(!empty($item->discount12)){
                    DB::table('user_discounts')->insert([
                        'user_id' => $user_id, 
                        'discount_id' => 4, 
                        'rate' => $item->discount12,
                        'description' => $item->discount12_text,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);                         
                }               
                
                if(!empty($item->discount13)){
                    DB::table('user_discounts')->insert([
                        'user_id' => $user_id, 
                        'discount_id' => 5, 
                        'rate' => $item->discount13,
                        'description' => $item->discount13_text,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);                         
                }    
                
                if(!empty($item->discount11)){
                    DB::table('user_discounts')->insert([
                        'user_id' => $user_id, 
                        'discount_id' => 6, 
                        'rate' => $item->discount11,
                        'description' => $item->discount11_text,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);                         
                }                    
            }  
            
            if($item->photo)
            {
                DB::table('photos')->insert(
                    [
                        'user_id' => $user_id, 
                        'url' => str_replace('uploads/', '', $item->photo),
                        'approved' => true,
                        'main' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );                    
            }

            if($item->photo_request)
            {
                DB::table('photos')->insert(
                    [
                        'user_id' => $user_id, 
                        'url' => str_replace('uploads/', '', $item->photo_request),
                        'approved' => false,
                        'main' => false,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );                    
            }   
            
            if($item->status == 'C' && $item->cancel_before_status)
            {
                DB::table('cancels')->insert(
                    [
                        'user_id' => $user_id, 
                        'reason' => $item->cancel_reason,
                        'last_status' => $item->cancel_before_status,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );                    
            }               
        }    
        */   

        $details = \App\Models\User_detail::whereNotNull('birthday')->get();
        foreach($details as $detail)
        {
            $birthday = \Carbon\Carbon::parse($detail->birthday)->format('d.m.Y');
            $detail->birthday = $birthday;
            $detail->save();
            
        }         
    }
}
