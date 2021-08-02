<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Alert;

class AlertController extends Controller
{
    public function AddAlert(Request $request){
        $product = DB::table('products')->where('id',$request->product_id)->first();
        if($product->product_quantity <= $product->min_quantity){
            $alert = new Alert;
            $alert->product_id = $request->product_id;
            $alert->user_id = $request->user_id;
            $alert->save();
        }
    }
    public function AlertProduct($user_id){
        $alert = DB::table('alerts')
        ->join('products','alerts.product_id','products.id')
        ->where('alerts.user_id',$user_id)
        ->select('products.product_name','products.product_quantity','products.image','products.product_code','alerts.*')
        ->get();
        return response()->json($alert);        
       } 
    public function removeAlert($id){
        $product = DB::table('products')->where('id',$id)->first();
        if ($product->product_quantity > $product->min_quantity){
            DB::table('alerts')->where('product_id',$id)->delete();
            return response('OK');
        }
        
    }
}
