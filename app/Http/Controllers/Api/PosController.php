<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;

class PosController extends Controller
{
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
   
    $data = array();
    $data['customer_id'] = $request->customer_id;
    $data['qty'] = $request->qty;
    $data['sub_total'] = $request->subtotal;
    $data['total'] = $request->total;
    $data['pay'] = $request->pay;
    $data['payby'] = $request->payby;
    $data['order_date'] = date('d/m/Y');
    $data['order_month'] = date('F');
    $data['order_year'] = date('Y');
    $order_id = DB::table('orders')->insertGetId($data);

    $contents = DB::table('pos')->get();

    $odata = array();
    foreach ($contents as $content) {
    $odata['order_id'] = $order_id;
    $odata['product_id'] = $content->pro_id;
    $odata['pro_quantity'] = $content->pro_quantity;
    $odata['product_price'] = $content->product_price;
    $odata['discount'] = $request->total_discount;
    $odata['sub_total'] = $content->sub_total;
    DB::table('order_details')->insert($odata); 

       
        DB::table('products')
        	->where('id',$content->pro_id)
        	->update(['product_quantity' => DB::raw('product_quantity -' .$content->pro_quantity)]);

    }
    DB::table('pos')->delete();
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
        ])->get();

    return response()->json($order);

  }



   public function TodaySell(){
     $date = date('d/m/Y');
     $sell = DB::table('orders')->where('order_date',$date)->sum('total');
     return response()->json($sell);
   }

   public function TodayIncome(){
     $date = date('d/m/Y');
     $income = DB::table('orders')->where('order_date',$date)->sum('pay');
     return response()->json($income);
   }

  

   public function TodayExpense(){
    $date = date('d/m/Y');
     $expense = DB::table('expenses')->where('expense_date',$date)->sum('amount');
     return response()->json($expense);
   }

 public function Stockout(){

  $product = DB::table('products')->where('product_quantity','<','1')->get();
  return response()->json($product);

 }
}
