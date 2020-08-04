<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPayment extends Model {
    protected $fillable = [
        'sale_id', 'payment'];
}