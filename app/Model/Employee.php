<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Employee extends Model
{
  use Uuids;
  
  public $incrementing = false;

     protected $fillable = [
        'name', 'email', 'phone','address','sallery','photo','nid','joining_date','user_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
 