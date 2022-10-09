<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');

        //DB::table('prices')->truncate();
        
        $prices = DB::connection('mysql')->select('SELECT * FROM core_prices WHERE uid IN(21230,21231,21232,21233,21234,21235,21236,21237,21238) AND price_live > 5 OR price_private > 5');
        foreach($prices as $price)
        {
            $new_user = DB::table('users')->where('old_id', $price->uid)->first();
            $new_subject = DB::table('subjects')->where('old_id', $price->subject_id)->first();
            $new_level = DB::table('levels')->where('old_id', $price->level_id)->first();
            if(!empty($new_user) && !empty($new_subject) && !empty($new_level))
            {
                $check_exists = DB::table('prices')->where('user_id', $new_user->id)->where('subject_id', $new_subject->id)->where('level_id', $new_level->id)->first();
                if(empty($check_exists))
                {
                    DB::table('prices')->insert(
                        [
                            'user_id' => $new_user->id,
                            'subject_id' => $new_subject->id, 
                            'level_id' => $new_level->id, 
                            'price_live' => $price->price_live, 
                            'price_private' => $price->price_private, 
                            'title' => $price->title, 
                            'description' => $price->description, 
                            'slug' => $price->seo_link, 
                            'status' => $price->status,
                            'created_at' => date('Y-m-d H:i:s', $price->date)
                        ]
                    );   
                }
            }   
        }  
        
        

    }
}
