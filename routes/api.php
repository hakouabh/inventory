<?php
use Illuminate\Http\Request;

// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {

//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('signup', 'AuthController@signup');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });

Route::middleware('auth:api')->group(function () {
  Route::get('/user', function (Request $request) {
      return $request->user();
  });
});

Route::group(['prefix' => 'auth'], function()
{
  
  Route::post('login', [
    'as' => 'api.auth.login',
    'uses' => 'AuthController@login',
  ]);
  Route::post('/register', [
    'as' => 'api.auth.register',
    'uses' => 'AuthController@register',
  ]);
  Route::post('/logout', [
    'as' => 'api.auth.logout',
    'middleware' => 'auth:api',
    'uses' => 'AuthController@logout',
  ]);
  Route::get('/me', [
    'as' => 'api.auth.me',
    'middleware' => 'auth:api',
    'uses' => 'AuthController@me',
  ]);
});

// Categories API
Route::group(['prefix' => 'categories'], function()
{
  Route::post('/store', [
    'as' => 'api.categories.store',
    'uses' => 'Api\CategoryController@store',
  ]);
  Route::get('/index/{user_id}', [
    'as' => 'api.categories.index',
    'uses' => 'Api\CategoryController@index',
  ]);
  Route::get('/show/{id}', [
    'as' => 'api.categories.show',
    'uses' => 'Api\CategoryController@show',
  ]);
  Route::put('/update/{id}', [
    'as' => 'api.categories.update',
    'uses' => 'Api\CategoryController@update',
  ]);
  Route::get('/destroy/{id}', [
    'as' => 'api.categories.destroy',
    'uses' => 'Api\CategoryController@destroy',
  ]);
});

// Customers API
Route::group(['prefix' => 'customers'], function()
{
  Route::post('/store', [
    'as' => 'api.customers.store',
    'uses' => 'Api\CustomerController@store',
  ]);
  Route::get('/position', [
    'as' => 'api.customers.position',
    'uses' => 'Api\CustomerController@position',
  ]);
  Route::get('/index/{user_id}', [
    'as' => 'api.customers.index',
    'uses' => 'Api\CustomerController@index',
  ]);
  Route::get('/show/{id}', [
    'as' => 'api.customers.show',
    'uses' => 'Api\CustomerController@show',
  ]);
  Route::put('/update/{id}', [
    'as' => 'api.customers.update',
    'uses' => 'Api\CustomerController@update',
  ]);
  Route::get('/destroy/{id}', [
    'as' => 'api.customers.destroy',
    'uses' => 'Api\CustomerController@destroy',
  ]);
});
// Employees API
Route::group(['prefix' => 'employees'], function()
{
  Route::post('/store', [
    'as' => 'api.employees.store',
    'uses' => 'Api\EmployeeController@store',
  ]);
  Route::get('/index/{user_id}', [
    'as' => 'api.employees.index',
    'uses' => 'Api\EmployeeController@index',
  ]);
  Route::get('/show/{id}', [
    'as' => 'api.employees.show',
    'uses' => 'Api\EmployeeController@show',
  ]);
  Route::put('/update/{id}', [
    'as' => 'api.employees.update',
    'uses' => 'Api\EmployeeController@update',
  ]);
  Route::get('/destroy/{id}', [
    'as' => 'api.employees.destroy',
    'uses' => 'Api\EmployeeController@destroy',
  ]);
});

// Suppliers API
Route::group(['prefix' => 'suppliers'], function()
{
  Route::post('/store', [
    'as' => 'api.suppliers.store',
    'uses' => 'Api\SupplierController@store',
  ]);
  Route::get('/index/{user_id}', [
    'as' => 'api.suppliers.index',
    'uses' => 'Api\SupplierController@index',
  ]);
  Route::get('/show/{id}', [
    'as' => 'api.suppliers.show',
    'uses' => 'Api\SupplierController@show',
  ]);
  Route::put('/update/{id}', [
    'as' => 'api.suppliers.update',
    'uses' => 'Api\SupplierController@update',
  ]);
  Route::get('/destroy/{id}', [
    'as' => 'api.suppliers.destroy',
    'uses' => 'Api\SupplierController@destroy',
  ]);
});
// Expenses API
Route::group(['prefix' => 'expenses'], function()
{
  Route::post('/store', [
    'as' => 'api.expenses.store',
    'uses' => 'Api\ExpenseController@store',
  ]);
  Route::get('/index/{user_id}', [
    'as' => 'api.expenses.index',
    'uses' => 'Api\ExpenseController@index',
  ]);
  Route::get('/show/{id}', [
    'as' => 'api.expenses.show',
    'uses' => 'Api\ExpenseController@show',
  ]);
  Route::put('/update/{id}', [
    'as' => 'api.expenses.update',
    'uses' => 'Api\ExpenseController@update',
  ]);
  Route::get('/destroy/{id}', [
    'as' => 'api.expenses.destroy',
    'uses' => 'Api\ExpenseController@destroy',
  ]);
});

// Products API
Route::group(['prefix' => 'products'], function()
{
  Route::post('/store', [
    'as' => 'api.products.store',
    'uses' => 'Api\ProductController@store',
  ]);
  Route::get('/index/{user_id}', [
    'as' => 'api.products.index',
    'uses' => 'Api\ProductController@index',
  ]);
  Route::get('/show/{id}', [
    'as' => 'api.products.show',
    'uses' => 'Api\ProductController@show',
  ]);
  Route::put('/update/{id}', [
    'as' => 'api.products.update',
    'uses' => 'Api\ProductController@update',
  ]);
  Route::get('/destroy/{id}', [
    'as' => 'api.products.destroy',
    'uses' => 'Api\ProductController@destroy',
  ]);
  Route::get('/stock/all/{id}', [
    'as' => 'api.products.StockAll',
    'uses' => 'Api\ProductController@StockAll',
  ]);
  Route::put('/stock/update/{id}', [
    'as' => 'api.products.StockUpdate',
    'uses' => 'Api\ProductController@StockUpdate',
  ]);
});

// Route::apiResource('/employee', 'Api\EmployeeController');
// Route::apiResource('/supplier', 'Api\SupplierController');
// Route::apiResource('/category', 'Api\CategoryController');
// Route::apiResource('/product', 'Api\ProductController');
// Route::apiResource('/expense', 'Api\ExpenseController');
// Route::apiResource('/customer', 'Api\CustomerController');
// Route::Post('/stock/update/{id}', 'Api\ProductController@StockUpdate');
// Route::Get('/stock/all', 'Api\ProductController@StockAll');
Route::Get('/product/stock', 'Api\ProductController@stock');
//-----------------------------------------------------------
Route::Post('/salary/paid/{id}', 'Api\SalaryController@Paid');
Route::Get('/salary/{id}', 'Api\SalaryController@AllSalary');
Route::Get('/salary/view/{id}', 'Api\SalaryController@ViewSalary');
Route::Get('/edit/salary/{id}', 'Api\SalaryController@EditSalary');
Route::Post('/salary/update/{id}', 'Api\SalaryController@SalaryUpdate');
//-----------------------------------------------------------
// Add to cart Route
Route::Get('/addToCart/{id}', 'Api\CartController@AddToCart');
Route::Get('/cart/product/{id}', 'Api\CartController@CartProduct');
Route::Get('/remove/cart/{id}', 'Api\CartController@removeCart');
Route::Get('/increment/{id}', 'Api\CartController@increment');
Route::Post('/checkquantity', 'Api\CartController@checkquantity');
Route::Get('/decrement/{id}', 'Api\CartController@decrement');
Route::Post('/discount', 'Api\CartController@discount');
//-----------------------------------------------------------
Route::Get('/orders/{id}', 'Api\OrderController@TodayOrder');
Route::Get('/order/details/{id}', 'Api\OrderController@OrderDetails');
Route::Get('/order/orderdetails/{id}', 'Api\OrderController@OrderDetailsAll');
Route::Get('/order/satat/{user_id}', 'Api\OrderController@stats');


Route::Post('/search/order', 'Api\PosController@SearchOrderDate');
Route::Get('/freefire', 'Api\PosController@getFreeFire');
Route::Post('/stats/order', 'Api\OrderController@StateOrderDate');
Route::Get('/getting/product/{id}', 'Api\PosController@GetProduct');
Route::Post('/search/product', 'Api\PosController@searchProduct');

// Admin Dashboard Route
Route::Post('/orderdone', 'Api\PosController@OrderDone');
Route::Get('/today/sell/{user_id}', 'Api\PosController@TodaySell');
Route::Get('/today/income/{user_id}', 'Api\PosController@TodayIncome');
Route::Get('/today/expense/{user_id}', 'Api\PosController@TodayExpense');
Route::Get('/today/stockout/{user_id}', 'Api\PosController@Stockout');


// Add to alert Route
Route::Post('/AddAlert', 'Api\AlertController@AddAlert');
Route::Get('/alert/product/{user_id}', 'Api\AlertController@AlertProduct');
Route::Get('/remove/alert/{id}', 'Api\AlertController@removeAlert');

//Sector
Route::Post('/sector/store', 'Api\SectorController@store');
Route::Get('/sector/index/{user_id}', 'Api\SectorController@index');
Route::Post('/sector/edit', 'Api\SectorController@edit');
Route::Post('/sector/delete', 'Api\SectorController@destroy');
