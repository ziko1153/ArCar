<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hire extends Model {
    protected $fillable = [
        'car_name', 'user_id', 'car_price','auction_fee','storage_fee','transport_fee', 'expense_fee', 'total_car_price', 'reg_no','delivery','comment',
        'auction_name', 'buying_date', 'auction_place', 'parking_place',
    ];

    protected $casts = [
        'buying_date' => 'Y-m-d',
    ];
    public function regComplete() {
        $this->car_name = 'hello';
        $this->save();
    }

    public function users() {

        return $this->belongsTo(User::class);

    }
}