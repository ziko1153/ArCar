<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
    protected $fillable = [
        'user_id', 'customer_id', 'sale_date', 'discount','sale_status',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function carList() {
        return $this->hasManyThrough('App\SalesCar','App\Hire','sale_id','id','car_id','id'); //// PRoblem 
    }
    public function saleList() {
        return $this->hasMany('App\SalesCar');
    }
    public function paymentList () {
        return $this->hasMany('App\SalesPayment');
    }


}