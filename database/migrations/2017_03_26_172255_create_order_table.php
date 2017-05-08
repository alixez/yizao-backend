<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('order_no');
            $table->integer('order_address')->default(0);

            $table->integer('user_id');
            $table->integer('deliver')->nullable(); // 配送员
            $table->string('order_status'); // 未支付, 已付款, 配送中, 完成
            $table->string('shipping_person')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_time')->nullable(); // 配送时间
            $table->string('shipping_money')->nullable(); // 配送费用
            $table->string('total_price')->nullable(); // 总价格
            $table->string('remark')->nullable(); // 备注

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
        Schema::dropIfExists('order');
    }
}
