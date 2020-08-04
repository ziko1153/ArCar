<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalCarHire extends Model {
    protected $fillable = [
        'user_id', 'customer_id', 'car_id', 'reg_no', 'hire_start_date',
        'hire_end_date', 'hire_rate', 'hire_status',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function paymentList() {
        return $this->hasMany('App\HiresPayment', 'hire_id')->orderBy('id', 'desc');
    }
}