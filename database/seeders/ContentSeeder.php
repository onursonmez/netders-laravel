<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');

        //DB::table('contents')->truncate();
        //DB::table('content_categories')->truncate();
        DB::table('comments')->truncate();
        DB::table('complaints')->truncate();
        DB::table('contact_forms')->truncate();
        DB::table('newsletter_emails')->truncate();
        DB::table('verified_emails')->truncate();
        
        /*
        $content_categories = DB::connection('mysql')->select('SELECT * FROM core_contents_categories WHERE id IN(1,570)');
        foreach($content_categories as $content_category)
        {
            $new_category_id = DB::table('content_categories')->insertGetId(
                [
                    'user_id' => 1,
                    'status' => 'A', 
                    'title' => $content_category->title,
                    'slug' => $content_category->seo_link,
                    'seo_title' => $content_category->seo_title,
                    'seo_description' => $content_category->seo_description,
                    'created_at' => date('Y-m-d H:i:s', $content_category->create_date)
                ]
            );    
            
            $contents = DB::connection('mysql')->select('SELECT * FROM core_contents WHERE main_category = ' . $content_category->id);
            foreach($contents as $content)
            {
                DB::table('contents')->insert(
                    [
                        'content_category_id' => $new_category_id,
                        'user_id' => 1, 
                        'status' => 'A', 
                        'title' => $content->title, 
                        'description' => $content->description, 
                        'views' => $content->views, 
                        'slug' => $content->seo_link, 
                        'seo_title' => $content->seo_title, 
                        'seo_description' => $content->seo_description, 
                        'created_at' => date('Y-m-d H:i:s', $content->start_date)
                    ]
                );  
            } 
        }
        

        $new_sartlar_ve_hukumler_category_id = DB::table('content_categories')->insertGetId(
            [
                'user_id' => 1,
                'status' => 'A', 
                'title' => 'Şartlar ve Hükümler',
                'slug' => 'sartlar-ve-hukumler',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );  
        
        $contents2 = DB::connection('mysql')->select("SELECT * FROM core_contents WHERE main_category = '0'");
        foreach($contents2 as $content2)
        {
            DB::table('contents')->insert(
                [
                    'content_category_id' => $new_sartlar_ve_hukumler_category_id,
                    'user_id' => 1, 
                    'status' => 'A', 
                    'title' => $content2->title, 
                    'description' => $content2->description, 
                    'views' => $content2->views, 
                    'slug' => $content2->seo_link, 
                    'created_at' => date('Y-m-d H:i:s', $content2->start_date)
                ]
            );  
        }  
        */
        
        $comments = DB::connection('mysql')->select('SELECT * FROM core_comments');
        foreach($comments as $comment)
        {
            $teacher = DB::table('users')->where('old_id', $comment->to_uid)->first();
            $creator = DB::table('users')->where('old_id', $comment->from_uid)->first();
            if(!empty($teacher) && !empty($creator))
            {
                DB::table('comments')->insert(
                    [
                        'user_id' => $teacher->id,
                        'creator_id' => $creator->id, 
                        'comment' => $comment->comment, 
                        'rating' => $comment->point, 
                        'status' => $comment->status, 
                        'created_at' => date('Y-m-d H:i:s', $comment->date)
                    ]
                );   
            }   
        } 
        
        $complaints = DB::connection('mysql')->select('SELECT * FROM core_complaints');
        foreach($complaints as $complaint)
        {
            $new_user = DB::table('users')->where('old_id', $complaint->teacher_id)->first();
            if(!empty($new_user))
            {
                DB::table('complaints')->insert(
                    [
                        'user_id' => $new_user->id,
                        'first_name' => $complaint->firstname ?? 'Bilinmeyen', 
                        'last_name' => $complaint->lastname ?? 'Bilinmeyen', 
                        'email' => $complaint->email ?? 'Bilinmeyen', 
                        'message' => $complaint->message, 
                        'created_at' => date('Y-m-d H:i:s', $complaint->date)
                    ]
                );   
            }   
        } 
        
        
        $forms = DB::connection('mysql')->select('SELECT * FROM core_forms');
        foreach($forms as $form)
        {
            DB::table('contact_forms')->insert(
                [
                    'first_name' => $form->firstname, 
                    'last_name' => $form->lastname, 
                    'email' => $form->email, 
                    'phone_mobile' => $form->phone, 
                    'message' => $form->message, 
                    'agent' => $form->uagent, 
                    'ip' => $form->ip, 
                    'created_at' => date('Y-m-d H:i:s', $form->date)
                ]
            );   
        }  
        
        
        $emails = DB::connection('mysql')->select('SELECT * FROM core_emails');
        foreach($emails as $email)
        {
            DB::table('newsletter_emails')->insert(
                [
                    'email' => $email->email, 
                    'ip' => $email->ip, 
                    'created_at' => date('Y-m-d H:i:s', $email->date)
                ]
            );   
        }     
            
        $verified_emails = DB::connection('mysql')->select('SELECT * FROM core_users_verified_emails');
        foreach($verified_emails as $verified_email)
        {
            $new_user = DB::table('users')->where('old_id', $verified_email->uid)->first();
            if(!empty($new_user))
            {                    
                DB::table('verified_emails')->insert(
                    [
                        'user_id' => $new_user->id, 
                        'email' => $verified_email->email, 
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );
            }  
        }              
       






    }
}
