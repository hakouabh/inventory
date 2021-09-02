<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Pos extends Model
{
  use Uuids;

  public $incrementing = false;

  
    protected $fillable = [
        'pro_id', 'pro_name', 'pro_quantity','product_price','product_discount','sub_total','user_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
