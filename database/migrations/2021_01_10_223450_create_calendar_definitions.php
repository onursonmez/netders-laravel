<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_definitions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('d1_from')->nullable();
            $table->string('d1_to')->nullable();
            $table->string('d2_from')->nullable();
            $table->string('d2_to')->nullable();            
            $table->string('d3_from')->nullable();
            $table->string('d3_to')->nullable();            
            $table->string('d4_from')->nullable();
            $table->string('d4_to')->nullable();            
            $table->string('d5_from')->nullable();
            $table->string('d5_to')->nullable();            
            $table->string('d6_from')->nullable();
            $table->string('d6_to')->nullable();            
            $table->string('d7_from')->nullable();
            $table->string('d7_to')->nullable();            
            $table->string('lesson_minute');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_definitions');
    }
}
