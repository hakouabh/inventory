<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Alert extends Model
{
  use Uuids;
    protected $fillable = [
        'product_id','user_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
} 
