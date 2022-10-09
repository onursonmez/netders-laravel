<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '2048M');


        DB::table('product_categories')->truncate();
        DB::table('products')->truncate();
        DB::table('orders')->truncate();
        DB::table('carts')->truncate();

        DB::table('product_categories')->insert(
            [
                'id' => 1,
                'title' => 'Üyelikler', 
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        DB::table('product_categories')->insert(
            [
                'id' => 2,
                'title' => 'Hizmetler', 
                'created_at' => date('Y-m-d H:i:s')
            ]
        );   

        $products = DB::connection('mysql')->select('SELECT * FROM core_products ORDER BY id ASC');
        foreach($products as $product)
        {
            $new_product_id = DB::table('products')->insertGetId(
                [
                    'title' => $product->title, 
                    'product_category_id' => $product->product_type, 
                    'expire_day' => $product->lifetime, 
                    'allowed_group_id' => $product->allowed_group_id, 
                    'new_group_id' => $product->group_id, 
                    'description' => $product->description, 
                    'search_point' => 1,
                    'price' => $product->price,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );   
        }         
    }
}
