<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('signup', 'AuthController@signup');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiResource('/employee', 'Api\EmployeeController');
Route::apiResource('/supplier', 'Api\SupplierController');
Route::apiResource('/category', 'Api\CategoryController');
Route::apiResource('/product', 'Api\ProductController');
Route::apiResource('/expense', 'Api\ExpenseController');
Route::apiResource('/customer', 'Api\CustomerController');

Route::Get('/product/stock', 'Api\ProductController@stock');

Route::Post('/salary/paid/{id}', 'Api\SalaryController@Paid');
Route::Get('/salary', 'Api\SalaryController@AllSalary');

Route::Get('/salary/view/{id}', 'Api\SalaryController@ViewSalary');
Route::Get('/edit/salary/{id}', 'Api\SalaryController@EditSalary');
Route::Post('/salary/update/{id}', 'Api\SalaryController@SalaryUpdate');

Route::Post('/stock/update/{id}', 'Api\ProductController@StockUpdate');
Route::Get('/stock/all', 'Api\ProductController@StockAll');

Route::Get('/getting/product/{id}', 'Api\PosController@GetProduct');

// Add to cart Route
Route::Get('/addToCart/{id}', 'Api\CartController@AddToCart');
Route::Get('/cart/product', 'Api\CartController@CartProduct');

Route::Get('/remove/cart/{id}', 'Api\CartController@removeCart');

Route::Get('/increment/{id}', 'Api\CartController@increment');
Route::Get('/decrement/{id}', 'Api\CartController@decrement');


Route::Post('/orderdone', 'Api\PosController@OrderDone');

Route::Get('/orders', 'Api\OrderController@TodayOrder');
Route::Get('/order/details/{id}', 'Api\OrderController@OrderDetails');
Route::Get('/order/orderdetails/{id}', 'Api\OrderController@OrderDetailsAll');

Route::Get('/order/satat', 'Api\OrderController@stats');

Route::Post('/search/order', 'Api\PosController@SearchOrderDate');

// Admin Dashboard Route

Route::Get('/today/sell', 'Api\PosController@TodaySell');
Route::Get('/today/income', 'Api\PosController@TodayIncome');
Route::Get('/today/expense', 'Api\PosController@TodayExpense');
Route::Get('/today/stockout', 'Api\PosController@Stockout');


// Add to alert Route
Route::Get('/AddAlert/{id}', 'Api\AlertController@AddAlert');
Route::Get('/alert/product', 'Api\AlertController@AlertProduct');
Route::Get('/remove/alert/{id}', 'Api\AlertController@removeAlert');
Route::Post('/discount', 'Api\CartController@discount');
