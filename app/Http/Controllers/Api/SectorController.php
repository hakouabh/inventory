<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Sector;
use Illuminate\Support\Str;
use DB;
class SectorController extends Controller
{
    public function store(Request $request){
        $sector = new Sector;
        $sector->name = Str::random(10);
        $sector->type = $request->type;
        $sector->user_id = $request->user_id;
        $sector->leaflet_id = $request->leaflet_id;
        $sector->data =$request->data;
        $sector->save();
    }
    public function index($user_id){
        $sectors = DB::table('sectors')
        ->where('user_id',$user_id)->get();

        return response()->json($sectors);
    }
}
