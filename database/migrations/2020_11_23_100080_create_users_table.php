<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();      
            $table->timestamp('email_verified_at')->nullable();            
            $table->rememberToken();                                        
            $table->bigInteger('old_id')->nullable();
            $table->foreignId('group_id')->constrained('groups')->onDelete('no action')->onUpdate('cascade');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->string('username', 100)->unique();
            $table->string('password', 60);       
            $table->char('status', 1)->default('W');            
            $table->boolean('online')->default(false);	
            $table->integer('search_point')->nullable();     
            $table->foreignId('timezone_id')->constrained('timezones')->onDelete('set null')->onUpdate('cascade')->default(16); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
