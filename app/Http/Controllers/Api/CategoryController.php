<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 


use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $category = DB::table('categories')->where('user_id',$user_id)->get();
        return response()->json($category);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_name' => ['required',Rule::unique('categories')->where('user_id',$request->user_id),'max:255']
           ]); 
           $category = Category::create([
            'category_name' => $request->input('category_name'),
            'user_id' => $request->user_id
          ]);
            return response()->json('ok');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DB::table('categories')->where('id',$id)->first();
       return response()->json($category);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['category_name'] = $request->category_name;
        $user = DB::table('categories')->where('id',$id)->update($data);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DB::table('categories')->where('id',$id)->delete();
        $category = Category::find($id);
        
        $category->delete();
    }
}
