<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarLessons extends Migration
{
    /**
     * Run the migrations.
     * status A: aktif
     *        C: tamamlanmış
     *        
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->char('status', 1)->default('W');            
            $table->decimal('price', 6, 2);
            $table->string('room_password')->nullable();
            $table->string('topic')->nullable();
            $table->timestamp('student_join_at')->nullable();
            $table->timestamp('teacher_join_at')->nullable();
            $table->string('student_link')->nullable();
            $table->string('teacher_link')->nullable();
            $table->text('student_login_password')->nullable();
            $table->text('teacher_login_password')->nullable();
            $table->smallInteger('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_lessons');
    }
}
