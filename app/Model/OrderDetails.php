<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class OrderDetails extends Model
{
  use Uuids;
  
    protected $fillable = [
        'order_id', 'product_id', 'pro_quantity','product_price','discount','sub_total'
    ];

}
