<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHiresTable extends Migration {
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up() {
  Schema::create('hires', function (Blueprint $table) {
   $table->id('id');
   $table->unsignedBigInteger('user_id');
   $table->string('reg_no');
   $table->text('car_name');
   $table->string('car_price');
   $table->string('auction_name');
   $table->string('auction_place')->nullable(true);
   $table->string('parking_place')->nullable(true);
   $table->date('buying_date');
   $table->string('invoice_upload')->nullable(true);
   $table->boolean('sale_status')->default(false);
   $table->timestamps();

   $table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down() {
  Schema::dropIfExists('hire');
 }
}