<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'order_product_id';
    public $timestamps = false;
}
