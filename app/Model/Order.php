<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Order extends Model
{
  use Uuids;

  public $incrementing = false;
  
  protected $fillable = [
        'customer_id', 'qty', 'sub_total','total','pay','payby','order_date','order_month','order_year'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
