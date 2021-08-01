<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('pro_id');
            $table->string('pro_name')->nullable();
            $table->string('pro_quantity')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_discount')->nullable();
            $table->string('sub_total')->nullable();
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
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
        Schema::dropIfExists('pos');
    }
}
