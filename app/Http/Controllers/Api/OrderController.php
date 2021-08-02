<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function TodayOrder($id){
      $data = date('d/m/Y');
      $order = DB::table('orders')
        ->join('customers','orders.customer_id','customers.id')
        ->where('order_date',$data)
        ->where('orders.user_id',$id)
        ->select('customers.name','orders.*')
        ->orderBy('orders.id','DESC')->get();
        
        return response()->json($order);
    }

    public function OrderDetails($id){
      $order = DB::table('orders')
        ->join('customers','orders.customer_id','customers.id')
        ->where('orders.id',$id)->select('customers.name','customers.phone','customers.address','orders.*')
        ->first();
        return response()->json($order);
    }

    public function OrderDetailsAll($id){
      $details = DB::table('order_details')
        ->join('products','order_details.product_id','products.id')
        ->where('order_details.order_id',$id)
        ->select('products.product_name','products.product_code','products.image','order_details.*')->get();
        return response()->json($details);
    }
    public function stats($user_id){
      $weeks = [0,1,2,3,4,5,6];
      $datenow1 = Carbon::now();
      $datenow2 = Carbon::now();

      $lw1 = Carbon::now()->subWeek();
      $lw2 = Carbon::now()->subWeek();

      //$lt = Carbon::now()->subWeek()->isoFormat('DD/MM/YYYY'); last week result
      //start of week in algeria
      $startOfWeek = $datenow1->startOfWeek()->addDays(-1)->isoFormat('DD/MM/YYYY');
      $endOfWeek = $datenow2->endOfWeek()->addDays(-1)->isoFormat('DD/MM/YYYY');
      
      $lwstartOfWeek = $lw1->startOfWeek()->addDays(-1)->isoFormat('DD/MM/YYYY');
      $lwendOfWeek = $lw2->endOfWeek()->addDays(-1)->isoFormat('DD/MM/YYYY');

      $currentWeekOrders = DB::table('orders')
      ->where('user_id',$user_id)
      ->whereBetween('order_date', [
        $startOfWeek,
        $endOfWeek
      ])->get();

      $lastWeekOrders = DB::table('orders')
      ->where('user_id',$user_id)
      ->whereBetween('order_date', [
        $lwstartOfWeek,
        $lwendOfWeek
      ])->get();

      $mapToZero = function($v) {
        return 0;
      };
      
      $graph = (object) [
        'currentWeekOrders' => (array) array_map($mapToZero, $weeks),
        'lastWeekOrders' => (array) array_map($mapToZero, $weeks)
      ];

      foreach ($weeks as $index) {
        foreach ($currentWeekOrders as $current) {
          $current_date = Carbon::now()->startOfWeek()->addDays($index-1);
          
          $current_dateformat=$current_date->isoFormat('DD/MM/YYYY');
          
          if($current_dateformat === $current->order_date) {  
            $revenue = $current->total;
            $graph->currentWeekOrders[$current_date->dayOfWeek] += $revenue;
          }
        }
        foreach ($lastWeekOrders as $last) {
          $last_date = Carbon::now()->subWeek()->startOfWeek()->addDays($index-1);
          
          $last_dateformat=$last_date->isoFormat('DD/MM/YYYY');
          
          if($last_dateformat === $last->order_date) {  
            $revenue = $last->total;
            $graph->lastWeekOrders[$last_date->dayOfWeek] += $revenue;
          }
        }
        // last week
      }
      return response()->json($graph);

    }
}
