<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory, Uuids;
     protected $fillable = [
        'name', 'type', 'user_id'
    ];


    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function stores()
    {
      return $this->hasMany('\App\Model\Customer');
    }
}
