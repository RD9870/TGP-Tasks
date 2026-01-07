<?php
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ImportCompanyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('products', [ProductController::class, 'index'])->middleware(CheckUserRole::class.':admin,manager,cashier');
    Route::get('products/{id}', [ProductController::class, 'show'])->middleware(CheckUserRole::class.':admin,manager');
    Route::post('products', [ProductController::class, 'store'])->middleware(CheckUserRole::class.':admin,manager');
    Route::put('products/{id}', [ProductController::class, 'update'])->middleware(CheckUserRole::class.':admin');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware(CheckUserRole::class.':admin');
Route::post('/receipts', [ReceiptController::class, 'store'])->middleware([CheckUserRole::class . ':cashier']);
    Route::get('/monthly-rate', [ProfitController::class, 'monthlyProfitRate'])->middleware(CheckUserRole::class.':admin,manager');
    Route::get('/detailed', [ProfitController::class, 'detailedProfits'])->middleware(CheckUserRole::class.':admin');

    //admin routes
Route::apiResource('users', UserController::class)->middleware([CheckUserRole::class . ':admin']);

    //category crud route
    Route::apiResource('categories',CategoryController::class)->middleware([CheckUserRole::class . ':admin']);
    //subcategory crud route
    Route::apiResource('subcategories',SubcategoryController::class)->middleware(CheckUserRole::class.':admin');

Route::get('categoriesfilter',[CategoryController::class,'filtercut'])->middleware(CheckUserRole::class.':manager,admin');
    //get the top and bottom products
    Route::get('products/overview/{limit}', [ProductController::class,"productsOverview"])->middleware(CheckUserRole::class.':admin,manager');
    //get the number of low stock items
    Route::get('lowStockCount', [ProductController::class,"lowStockCount"])->middleware(CheckUserRole::class.':admin,manager');
    Route::get('products/sub/{subCategory}', [ProductController::class, 'filterBySub'])->middleware(CheckUserRole::class.':admin,manager,cashier');


Route::get('manufacturers', [ManufacturerController::class, 'index']);
Route::get('import-companies', [ImportCompanyController::class, 'index']);

//manager routes
    //category crud route
    Route::apiResource('categoriesm',CategoryController::class)->only(['index','show','store'])->middleware(CheckUserRole::class.':manager');
    //subcategory crud route
    Route::apiResource('subcategoriesm',SubcategoryController::class)->only(['index','show','store'])->middleware(CheckUserRole::class.':manager');
});
