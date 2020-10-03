<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_product', function (Blueprint $table) {
            $table->id();
            $table->string('post_name');
            $table->string('post_description');
            $table->string('category');
            $table->integer('price');
            $table->integer('sale');
            $table->integer('amount');
            $table->integer('sold');
            $table->string('post_images')->nullable($value = true);
            $table->string('post_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_product');
    }
}
