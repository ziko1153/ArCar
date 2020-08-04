<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalCarHiresTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('personal_car_hires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('car_id');
            $table->string('reg_no')->nullable(true);
            $table->date('hire_start_date');
            $table->date('hire_end_date')->nullable(true);
            $table->double('hire_rate');
            $table->boolean('hire_status')->default(true);
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('car_id')
                ->references('id')
                ->on('personal_car_adds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('personal_car_hires');
    }
}