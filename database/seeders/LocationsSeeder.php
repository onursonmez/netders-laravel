<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '4096M');

        
        //DB::table('locations')->truncate();
        
        $locations = DB::connection('mysql')->select('SELECT * FROM core_locations WHERE uid IN(21230,21231,21232,21233,21234,21235,21236,21237,21238)');
        foreach($locations as $location)
        {
            $new_user = DB::table('users')->where('old_id', $location->uid)->first();
            $new_city = DB::table('cities')->where('old_id', $location->city)->first();
            $new_town = DB::table('towns')->where('old_id', $location->town)->first();
            if(!empty($new_user) && !empty($new_city) && !empty($new_town))
            {
                $check_exists = DB::table('locations')->where('user_id', $new_user->id)->where('city_id', $new_city->id)->where('town_id', $new_town->id)->first();
                if(empty($check_exists))
                {
                    DB::table('locations')->insert(
                        [
                            'user_id' => $new_user->id,
                            'city_id' => $new_city->id, 
                            'town_id' => $new_town->id, 
                            'created_at' => date('Y-m-d H:i:s', $location->date)
                        ]
                    );   
                    }
            }   
        }
        
        /*

        $items = DB::connection('mysql')->select('SELECT * FROM core_users where birthday is not null order by id asc');
        foreach($items as $item)
        {
            $user = \App\Models\User::where('old_id', $item->id)->first();
            $city = \App\Models\City::where('old_id', $item->city)->first();
            $town = \App\Models\Town::where('old_id', $item->town)->first();

            if(empty($town))
            {
                print_r($item);
            }
            else
            {
            $detail = \App\Models\User_detail::where('user_id', $user->id)->first();            
            $detail->city_id = $city->id;
            $detail->town_id = $town->id;
            $detail->save();
            }
            
        }    
        */
        
        
        
        

    }
}
