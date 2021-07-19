<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id){
        $product = DB::table('products')->where('id',$id)->first();
        if($product->product_quantity >=1){
            //check to increment or add
            $check = DB::table('pos')->where('pro_id',$id)->first();
            if($check){ 
                //increment
                if($check->pro_quantity >=$product->product_quantity){
                    // out of stock
                    return response()->json('out of stock');
                }else{
                    DB::table('pos')->where('pro_id',$id)->increment('pro_quantity');
                    $product = DB::table('pos')->where('pro_id',$id)->first();
                    $subtotal = $product->pro_quantity * $product->product_price;
                    DB::table('pos')->where('pro_id',$id)->update(['sub_total'=>$subtotal]);
                } 
            }else{
                //add
                $data = array();
                $data['pro_id'] = $id;
                $data['pro_name'] = $product->product_name;
                $data['pro_quantity'] = 1;
                $data['product_price'] = $product->selling_price;
                $data['sub_total'] = $product->selling_price;        
                DB::table('pos')->insert($data);
            }
        }else{
            return response('error');
        }
       
    }

    public function CartProduct(){
        $cart = DB::table('pos')->get();
           return response()->json($cart);
       }
       
    public function removeCart($id){

        DB::table('pos')->where('id',$id)->delete();
        return response('OK');
    }

    public function increment($id){

        $posCheque = DB::table('pos')->where('id',$id)->first();
        $productCheck = DB::table('products')->where('id',$posCheque->pro_id)->select('products.product_quantity as qte')->first();

        if($productCheck->qte > $posCheque->pro_quantity){

            $quantity = DB::table('pos')->where('id',$id)->increment('pro_quantity');
            $product = DB::table('pos')->where('id',$id)->first();
            $subtotal = $product->pro_quantity * $product->product_price;
            DB::table('pos')->where('id',$id)->update(['sub_total'=>$subtotal]);
            return response('ok');
        }

        
    }
    public function decrement($id){

        $quantity = DB::table('pos')->where('id',$id)->decrement('pro_quantity');
        $product = DB::table('pos')->where('id',$id)->first();
        $subtotal = $product->pro_quantity * $product->product_price;
        DB::table('pos')->where('id',$id)->update(['sub_total'=>$subtotal]);
        return response('OK');
    }

    public function Vats(){

        $vat = DB::table('extra')->first();
        return response()->json($vat);
    }
}
