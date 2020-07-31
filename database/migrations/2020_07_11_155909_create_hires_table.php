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
   $table->double('car_price');
   $table->double('auction_fee')->default(0);
   $table->double('storage_fee')->default(0);
   $table->double('transport_fee')->default(0);
   $table->double('expense_fee')->default(0);
   $table->double('total_car_price');
   $table->string('auction_name');
   $table->string('auction_place')->nullable(true);
   $table->string('parking_place')->nullable(true);
   $table->date('buying_date');
   $table->string('invoice_upload')->nullable(true);
   $table->string('delivery')->nullable(true); 
   $table->string('comment')->nullable(true);
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