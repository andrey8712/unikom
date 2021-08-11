<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('carrier_id');
            $table->integer('driver_id')->nullable();
            $table->integer('car_id')->nullable();
            $table->string('desired_date')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('home')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('loading_top')->nullable();
            $table->boolean('loading_back')->nullable();
            $table->boolean('loading_side')->nullable();
            $table->integer('client_price')->nullable();
            $table->integer('driver_price')->nullable();
            $table->string('ttn_number')->nullable();
            $table->smallInteger('current_status');
            $table->smallInteger('payment_status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('delivery_products', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_id');
            $table->integer('product_id');
            $table->integer('product_count');
            $table->softDeletes();
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
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('delivery_products');
    }
}
