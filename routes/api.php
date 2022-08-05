//todas las rutas relacionadas con la apirestful 
<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*Buyers  */ 
Route::resource('buyers','Buyer\BuyerController',['only'=> ['index','show']]);

/*Category */
Route::resource('categories','Category\CategoryController',['except'=> ['create','edit']]);

/*Prducts */
Route::resource('products','Product\ProductController',['only'=> ['index','show']]);

/*Transactions */ 
Route::resource('transactions','Transaction\TransactionController',['only'=> ['index','show']]);

/*Sellers */
Route::resource('seller','Seller\SellerController',['only'=> ['index','show']]);

/*Users */
Route::resource('users','User\UserController',['except'=> ['create','edit']]);