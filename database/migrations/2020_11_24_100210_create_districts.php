<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistricts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('town_id')->constrained('towns')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title', 100);            
            $table->string('slug', 100);            
            $table->char('status', 1);            
            
            $table->unique(['town_id', 'title']);
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
