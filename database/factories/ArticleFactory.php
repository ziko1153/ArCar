<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hire;
use Faker\Generator as Faker;

$factory->define(Hire::class, function (Faker $faker) {
 return [
  'user_id' => factory(App\User::class),
  'reg_no' => $faker->sentence(),
  'car_name' => $faker->sentence(),
  'car_price' => $faker->numberBetween(100, 20000),
  'auction_name' => $faker->sentence(),
  'buying_date' => $faker->date('Y-m-d'),

 ];
});