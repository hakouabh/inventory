<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Category extends Model
{
  use Uuids;
  
    protected $fillable = [
        'category_name','user_id'
    ];
    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
