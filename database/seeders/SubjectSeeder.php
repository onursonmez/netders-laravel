<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');


        DB::table('subjects')->truncate();
        DB::table('levels')->truncate();

        $items = DB::connection('mysql')->select('SELECT * FROM core_contents_categories WHERE parent_id = 6');
        foreach($items as $item)
        {
            $subject_id = DB::table('subjects')->insertGetId(
                [
                    'title' => $item->title, 
                    'old_id' => $item->id, 
                    'status' => $item->status, 
                    'seo_title' => $item->seo_title, 
                    'seo_description' => $item->seo_description, 
                    'slug' => $item->seo_link, 
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );

            $items2 = DB::connection('mysql')->select('SELECT * FROM core_contents_categories WHERE parent_id = ' . $item->id);
            foreach($items2 as $item2)
            {
                $level_id = DB::table('levels')->insertGetId(
                    [
                        'subject_id' => $subject_id,
                        'old_id' => $item2->id,
                        'title' => $item2->title, 
                        'status' => $item2->status, 
                        'seo_title' => $item->seo_title . '-' . $item2->seo_title, 
                        'seo_description' => $item2->seo_description, 
                        'slug' => $item->seo_link . '-' . $item2->seo_link, 
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );                  
            }      
        }
    }
}
