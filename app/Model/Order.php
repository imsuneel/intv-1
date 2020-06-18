<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function OrderProduct() {
        return $this->hasMany('App\Model\OrderProduct'); 
    }
}
