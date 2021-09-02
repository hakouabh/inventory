<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Expense extends Model
{
  use Uuids;
  
  public $incrementing = false;

    protected $fillable = [
        'details', 'amount','user_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
} 
