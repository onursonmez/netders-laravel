<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_at');
            $table->timestamp('end_at');             
            $table->timestamp('updated_at');             
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('no action')->onUpdate('cascade');
            $table->decimal('used_money', 6, 2);
            $table->decimal('earn_money', 6, 2);
            $table->decimal('product_price', 6, 2);
            $table->decimal('payed_price', 6, 2);
            $table->string('merchant_oid', 60);
            $table->char('status', 1)->default('A');
            $table->boolean('expired')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
