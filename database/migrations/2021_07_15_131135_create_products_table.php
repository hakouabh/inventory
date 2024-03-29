<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('category_id');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('buying_price')->nullable();
            $table->string('selling_price');
            $table->uuid('supplier_id')->nullable();
            $table->string('buying_date')->nullable();
            $table->string('image')->nullable();
            $table->string('product_quantity');
            $table->string('min_quantity');
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
        Schema::dropIfExists('products');
    }
}
