<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalCarAdd extends Model {
    protected $fillable = [
        'car_name', 'reg_no', 'hire_status',
    ];
}