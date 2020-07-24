<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
    protected $fillable = [
        'user_id', 'customer_id', 'sale_date', 'discount',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }
    public function customers() {
        return $this->belongsToMany(Customer::class);
    }

}