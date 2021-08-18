<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Sector;

class SectorController extends Controller
{
    public function store(Request $request){
        $sector = new Sector;
        
    }
}
