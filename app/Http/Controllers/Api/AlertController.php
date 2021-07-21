<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Alert;

class AlertController extends Controller
{
    public function AddAlert(Request $request,$id){
        $product = DB::table('products')->where('id',$id)->first();
        if($product->product_quantity <= $product->product_quantity){
            $alert = new Alert;
            $alert->product_id = $id;
            $alert->save();
        }
    }
    public function AlertProduct(){
        $alert = DB::table('alerts')
        ->join('products','alerts.product_id','products.id')
        ->select('products.product_name','products.product_quantity','products.image','products.product_code','alerts.*')
        ->get();
        return response()->json($alert);        
       } 
    public function removeAlert($id){
        $product = DB::table('products')->where('id',$id)->first();
        if ($product->product_quantity > $product->product_quantity){
            DB::table('alerts')->where('product_id',$id)->delete();
            return response('OK');
        }
        
    }
}
