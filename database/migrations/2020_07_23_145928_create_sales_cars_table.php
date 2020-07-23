<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCarsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sales_cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('car_id');
            $table->double('sale_price');
            $table->timestamps();
            $table->foreign('sale_id')
                ->references('id')
                ->on('sales');
            $table->foreign('car_id')
                ->references('id')
                ->on('hires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sales_cars');
    }
}