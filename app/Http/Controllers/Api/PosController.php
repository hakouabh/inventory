<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;
use App\Model\Order;
use App\Model\OrderDetails;
use App\Model\Product;
use App\Model\FreeFire;

class PosController extends Controller
{
  public function __construct(){
    $this->content = array();
}
   public function GetProduct($id){

   	$product = DB::table('products')
   		->where('category_id',$id)
   		->get();
   		return response()->json($product);

   } 

   public function OrderDone(Request $request){

   	 $validatedData = $request->validate([
      'customer_id' => 'required',
      'payby' => 'required',
   	 ]);
   
    $order = new Order;
    $order->customer_id = $request->customer_id;
    $order->qty = $request->qty;
    $order->sub_total = $request->subtotal;
    $order->total = $request->total;
    $order->pay = $request->pay;
    $order->payby = $request->payby;
    $order->order_date = date('d/m/Y');
    $order->order_month = date('F');
    $order->order_year = date('Y');
    $order->user_id = $request->user_id;
    $order->save();
    $_id = $order->id;

    $contents = DB::table('pos')->where('user_id',$request->user_id)
    ->get();

    foreach ($contents as $content) {
    $order_details = new OrderDetails;
    $order_details->order_id = $_id;
    $order_details->product_id = $content->pro_id;
    $order_details->pro_quantity = $content->pro_quantity;
    $order_details->product_price = $content->product_price;
    $order_details->discount = $request->total_discount;
    $order_details->sub_total = $content->sub_total;
    
    $order_details->save(); 

       
        Product::where('id',$content->pro_id)
        	->update(['product_quantity' => DB::raw('product_quantity -' .$content->pro_quantity),
        ]);

    }
    DB::table('pos')->where('user_id',$request->user_id)->delete();
    return response('Done'); 

   }
 

  public function SearchOrderDate(Request $request){
    $orderdate_from = $request->date_from;
    $orderdate_to = $request->date_to;
    $newdate_from = new DateTime($orderdate_from);
    $newdate_to = new DateTime($orderdate_to);
    $done_from = $newdate_from->format('d/m/Y'); 
    $done_to = $newdate_to->format('d/m/Y'); 

    $order = DB::table('orders')
        ->join('customers','orders.customer_id','customers.id')
        ->select('customers.name','orders.*')
        ->whereBetween('orders.order_date', [
          $done_from,
          $done_to
        ])
        ->where('orders.user_id',$request->user_id)
        ->get();

    return response()->json($order);

  }



   public function TodaySell($user_id){
     $date = date('d/m/Y');
     $sell = DB::table('orders')
     ->where('order_date',$date)
     ->where('user_id',$user_id)
     ->sum('total');
     return response()->json($sell);
   }

   public function TodayIncome($user_id){
     $date = date('d/m/Y');
     $income = DB::table('orders')
     ->where('order_date',$date)
     ->where('user_id',$user_id)
     ->sum('pay');
     return response()->json($income);
   }

  

   public function TodayExpense($user_id){
    $date = date('d/m/Y');
     $expense = DB::table('expenses')
     ->where('expense_date',$date)
     ->where('user_id',$user_id)
     ->sum('amount');
     return response()->json($expense);
   }

 public function Stockout($user_id){

  $product = DB::table('products')
  ->where('user_id',$user_id)
  ->where('product_quantity','<','1')->get();
  return response()->json($product);

 }
 public function searchProduct(Request $request){
        $product = DB::table('products')
        ->where('product_code',$request->product_code)
        ->where('user_id',$request->user_id)->get();
        return response()->json($product);
 }
}
