<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Product extends Model
{
  use Uuids;
    protected $fillable = [
        'category_id', 'product_name', 'product_code','buying_price','selling_price'
        ,'supplier_id','buying_date','image','product_quantity','min_quantity','user_id'
    ];
    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
