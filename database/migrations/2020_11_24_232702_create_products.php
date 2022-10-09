<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_category_id')->constrained('product_categories')->onDelete('no action')->onUpdate('cascade');
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 6, 2);
            $table->char('status', 1)->default('A');
            $table->tinyInteger('new_group_id')->nullable();
            $table->tinyInteger('expire_count')->nullable();
            $table->string('expire_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
