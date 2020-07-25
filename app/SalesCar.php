<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesCar extends Model
{
    protected $fillable = [
        'sale_id', 'car_id', 'sale_price'
    ];
    public function carList() {
        return $this->belongsTo('App\Hire');
    }
}
