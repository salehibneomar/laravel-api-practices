<?php

use App\Http\Controllers\BuyerCategoryController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\BuyerProductController;
use App\Http\Controllers\BuyerSellerController;
use App\Http\Controllers\BuyerTransactionController;
use App\Http\Controllers\CategoryBuyerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CategorySellerController;
use App\Http\Controllers\CategoryTransactionController;
use App\Http\Controllers\ProductBuyerController;
use App\Http\Controllers\ProductBuyerTransactionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\SellerBuyerController;
use App\Http\Controllers\SellerCategoryController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerTransactionController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionSellerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//1 User Routes
Route::get('/users', [UserController::class, 'index'])
     ->name('users.all');
Route::get('/user/{id}', [UserController::class, 'show'])
     ->name('user.single');
Route::post('/user', [UserController::class, 'store'])
     ->name('user.store');
Route::put('/user/{id}', [UserController::class, 'update'])
     ->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])
     ->name('user.destroy');
Route::get('/user/verify/{token}', [UserController::class, 'verify'])
     ->name('user.verify');              

//2 Buyer routes
Route::get('/buyers', [BuyerController::class, 'index'])
     ->name('buyers.all');
Route::get('/buyer/{id}', [BuyerController::class, 'show'])
     ->name('buyer.single');
Route::get('buyer/{buyer}/transactions', [BuyerTransactionController::class, 'index'])
     ->name('buyer.transactions');
Route::get('buyer/{buyer}/products', [BuyerProductController::class, 'index'])
     ->name('buyer.products');
Route::get('buyer/{buyer}/sellers', [BuyerSellerController::class, 'index'])
     ->name('buyer.sellers');
Route::get('buyer/{buyer}/categories', [BuyerCategoryController::class, 'index'])
     ->name('buyer.categories');     

//3 Seller routes
Route::get('/sellers', [SellerController::class, 'index'])
     ->name('sellers.all');
Route::get('/seller/{id}', [SellerController::class, 'show'])
     ->name('seller.single');
Route::get('/seller/{seller}/products', [SellerProductController::class, 'index'])
     ->name('seller.products');
Route::post('/seller/{seller}/product', [SellerProductController::class, 'store'])
     ->name('seller.product.store');
Route::put('/seller/{seller}/product/{product}', [SellerProductController::class, 'update'])
     ->name('seller.product.update');
Route::delete('/seller/{seller}/product/{product}', [SellerProductController::class, 'destroy'])
     ->name('seller.product.delete');
Route::get('/seller/{seller}/categories', [SellerCategoryController::class, 'index'])->name('seller.categories');
Route::get('/seller/{seller}/transactions', [SellerTransactionController::class, 'index'])->name('seller.transactions');
Route::get('/seller/{seller}/buyers', [SellerBuyerController::class, 'index'])->name('seller.buyers');

//4 Category routes
Route::get('/categories', [CategoryController::class, 'index'])
     ->name('categories.all');
Route::get('/category/{id}', [CategoryController::class, 'show'])
     ->name('category.single');
Route::post('/category', [CategoryController::class, 'store'])
     ->name('category.store');
Route::put('/category/{id}', [CategoryController::class, 'update'])
     ->name('category.update');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])
     ->name('category.destroy');
Route::get('category/{category}/products', [CategoryProductController::class, 'index'])
     ->name('category.products');
Route::get('category/{category}/sellers', [CategorySellerController::class, 'index'])
     ->name('category.sellers');
Route::get('category/{category}/transactions', [CategoryTransactionController::class, 'index'])
     ->name('category.transactions');
Route::get('category/{category}/buyers', [CategoryBuyerController::class, 'index'])
     ->name('category.buyers');               
     
//5 Product routes
Route::get('/products', [ProductController::class, 'index'])
     ->name('products.all');
Route::get('/product/{id}', [ProductController::class, 'show'])
     ->name('product.single');
Route::post('/product/{product}/buyer/{buyer}/transaction', [ProductBuyerTransactionController::class, 'store'])
     ->name('product.buyer.transaction.store');
Route::get('/product/{product}/transactions', [ProductTransactionController::class, 'index'])
     ->name('product.transactions');
Route::get('product/{product}/buyers', [ProductBuyerController::class, 'index'])
     ->name('product.buyers');
Route::get('product/{product}/category', [ProductCategoryController::class, 'index'])
     ->name('product.category');     

//6 Transaction routes
Route::get('/transactions', [TransactionController::class, 'index'])
     ->name('transactions.all');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])
     ->name('transaction.single'); 
Route::get('/transaction/{transaction}/seller', [TransactionSellerController::class, 'index'])->name('transaction.seller');
Route::get('/transaction/{transaction}/category', [TransactionCategoryController::class, 'index'])
     ->name('transaction.category');