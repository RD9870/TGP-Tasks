<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\AuthController as AuthorAuthController;
use App\Http\Controllers\Author\BookController;
use App\Http\Controllers\Author\CategoryController as AuthorCategoryController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\BookController as CustomerBookController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CategoryController as CustomerCategoryController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthorMiddleware;
use App\Http\Middleware\CustomerMiddleware;
// use App\Http\Middleware\UserMiddleware;
// use App\Models\Customer;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//login rout open for unauthorized users
Route::post('/login',[AuthController::class,'login']);

//logout route open only to authorized user (admin, customer, authour)
Route::post('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);

//update profile route open only to authorized user
Route::patch('/profile/edit',[UserController::class,'updateProfile'])->middleware(['auth:sanctum']);


//admin routes
Route::prefix('admin')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    //category route to index store show update and destroy categories from database
    Route::apiResource('category',CategoryController::class);
    //author route to index and aprove authors from database
    Route::apiResource('author',AuthorController::class);
    //route to block a user => user name is included in the request parmeter
    Route::post('blockUser',[AdminUserController::class, "blockUser"]);
    //rout to change the order status reques params are the order id and the new status
    Route::post('changeOrderStatus',[AdminOrderController::class, "changeOrderStatus"]);
    //rout to aprove the author with the used id
    Route::put('author/{author}/approve',[AuthorController::class,'approve']);
});


//route to sign up a new customer
Route::post('customer/sign-up',[CustomerAuthController::class,'signup']);

//customer routes
Route::prefix('customer')->middleware(['auth:sanctum',CustomerMiddleware::class])->group(function(){
    //rout that gets all books and if the request has a cat param only books with that cat is shown
    Route::apiResource('book',CustomerBookController::class)->only(['index','show']);
    //route to show all the avaliable categories
    Route::apiResource('category',CustomerCategoryController::class)->only('index');
    //route to show all the cart items and remove a cart item
    Route::apiResource('cart',CartController::class)->except('store');
    //route to add new book to cart
    Route::post('cart/{book}',[CartController::class,'store']);
    //route to change payment method nem mwthod in body
    Route::patch('changePayment',[CartController::class,'changePaymentMethod']);
    //route tochange the address in cart and customer
    Route::patch('changeAddress',[UserController::class,'changeAddress']);
    //my filter by category
    Route::get('book/category/{cat}',[CustomerBookController::class,'filterByCategory']);
    //customer checks out creates new order and empties the cart
    Route::get('checkout',[OrderController::class,'checkOut']);
    //route to view past orders
    Route::get('orders',[OrderController::class,'showOrders']);
});

//TODO:here and down need postman tests
//sign up as an author route open for unauthorized users
Route::post('author/sign-up',[AuthorAuthController::class,'signup']);

//sll suthor related routes
Route::prefix('author')->middleware(['auth:sanctum',AuthorMiddleware::class])->group(function(){
    //publish a new book
    Route::post('publish', [BookController::class, "publishNewBook"]);
    //update stock for a specific user
    Route::patch('stock/{book}',[BookController::class, "updateStock"]);
    //view info about the number of orders for your books
    Route::get('orders',[BookController::class, "getAuthorOrders"]);
    //route for author to view the avaliable categories
    Route::apiResource('category',AuthorCategoryController::class)->only('index');
});








