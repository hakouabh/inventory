<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Salary extends Model
{
  use Uuids;
  
    protected $fillable = [
        'employee_id', 'amount', 'salary_date','salary_month','salary_year'
    ];

    public function company()
    {
      return $this->belongsTo('\App\User');
    }
}
