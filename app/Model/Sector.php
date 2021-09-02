<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Sector extends Model
{
    use HasFactory, Uuids;

    public $incrementing = false;

     protected $fillable = [
        'name', 'type', 'user_id','data'
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
