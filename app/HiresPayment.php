<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiresPayment extends Model {
    protected $fillable = [
        'hire_id', 'payment'];
}