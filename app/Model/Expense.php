<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
  use Uuids;
    protected $fillable = [
        'details', 'amount','user_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
} 
