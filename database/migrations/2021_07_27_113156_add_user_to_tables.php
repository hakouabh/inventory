<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_user_id_foreign');
            $table->dropIndex('products_user_id_index');

            $table->dropColumn('user_id');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_user_id_foreign');
            $table->dropIndex('employees_user_id_index');

            $table->dropColumn('user_id');
        });

        Schema::table('suppliers', function (Blueprint $table) {
              $table->dropForeign('suppliers_user_id_foreign');
              $table->dropIndex('suppliers_user_id_index');

            $table->dropColumn('user_id');
        });

        Schema::table('categories', function (Blueprint $table) {
              $table->dropForeign('categories_user_id_foreign');
              $table->dropIndex('categories_user_id_index');

            $table->dropColumn('user_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
              $table->dropForeign('expenses_user_id_foreign');
              $table->dropIndex('expenses_user_id_index');

            $table->dropColumn('user_id');
        });

        Schema::table('customers', function (Blueprint $table) {
              $table->dropForeign('customers_user_id_foreign');
              $table->dropIndex('customers_user_id_index');

            $table->dropColumn('user_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
            $table->dropIndex('lists_user_id_index');

            $table->dropColumn('user_id');
        });
    }
}
