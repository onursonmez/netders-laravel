<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');       
            $table->string('phone_mobile', 100)->nullable();
            $table->char('birthday', 10)->nullable();            
            $table->integer('city_id')->nullable();            
            $table->integer('town_id')->nullable();     
            $table->char('gender', 1)->nullable();	
            $table->tinyInteger('profession_id')->nullable();
            $table->string('title', 255)->nullable();	
            $table->text('long_text')->nullable();	
            $table->text('reference_text')->nullable();	
            $table->string('company_title', 100)->nullable();	
            $table->char('privacy_lastname', 2)->default(1);            
            $table->char('privacy_phone', 2)->default(1);            
            $table->char('privacy_age', 2)->default(1);            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
