<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    protected $fillable = [
        'cust_name', 'cust_email', 'cust_mobile','cust_ni', 'cust_address',
    ];
}