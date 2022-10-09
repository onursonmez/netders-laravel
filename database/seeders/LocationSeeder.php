<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Cviebrock\EloquentSluggable\Services\SlugService;

use App\Models\District;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');


        DB::table('cities')->truncate();
        DB::table('towns')->truncate();
        DB::table('districts')->truncate();

        $cities = DB::connection('mysql')->select('SELECT * FROM core_locations_cities');
        foreach($cities as $city)
        {
            $new_city_id = DB::table('cities')->insertGetId(
                [
                    'old_id' => $city->id,
                    'country_id' => 1, 
                    'title' => $city->title, 
                    'slug' => $city->seo_link, 
                    'status' => $city->status, 
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );

            $towns = DB::connection('mysql')->select('SELECT * FROM core_locations_towns WHERE city_id = ' . $city->id);
            foreach($towns as $town)
            {
                $new_town_id = DB::table('towns')->insertGetId(
                    [
                        'old_id' => $town->id,
                        'city_id' => $new_city_id,
                        'title' => $town->title, 
                        'slug' => $city->seo_link . '-' . $town->seo_link, 
                        'status' => $town->status, 
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );    
                
                $districts = DB::connection('mysql')->select('SELECT * FROM core_locations_districts WHERE town_id = ' . $town->id);
                foreach($districts as $district)
                {
                    DB::table('districts')->insert(
                        [
                            'town_id' => $new_town_id,
                            'title' => $district->title, 
                            'slug' => $city->seo_link . '-' . $town->seo_link . '-' . SlugService::createSlug(District::class, 'slug', $district->title),
                            'status' => $district->status, 
                            'created_at' => date('Y-m-d H:i:s')
                        ]
                    );    
                }                                
            }      
        }        
    }
}
