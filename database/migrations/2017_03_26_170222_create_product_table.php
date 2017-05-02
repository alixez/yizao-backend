<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('prod_id');
            $table->integer('prod_cover_id')->unsigned();
            $table->integer('prod_type_id')->unsigned();
            $table->string('prod_title');
            $table->string('prod_desc');
            $table->string('prod_body');
            $table->integer('prod_price');
            $table->integer('prod_total_sales')->default(0);
            $table->integer('prod_permonth_sales')->default(0);
            $table->integer('prod_daily_sales')->default(0);

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
        Schema::dropIfExists('product');
    }
}
