<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHiresPaymentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('hires_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hire_id');
            $table->double('payment');
            $table->text('reference')->nullable(true);
            $table->timestamps();
            $table->foreign('hire_id')
                ->references('id')
                ->on('personal_car_hires')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('hires_payments');
    }
}