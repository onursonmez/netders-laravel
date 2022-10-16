<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConversationDeletedMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_deleted_messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('message_id')->constrained('conversation_messages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
