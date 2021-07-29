<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Customer extends Model
{
  use Uuids;
  
    protected $fillable = [
        'name', 'email', 'phone','address','photo','user_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
