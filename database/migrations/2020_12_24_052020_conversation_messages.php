<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConversationMessages extends Migration
{
    /**
     * message_type: 1 message, 2 file, 3 sound, 4 video
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->char('message_type', 1)->default(1);
            $table->string('message', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
