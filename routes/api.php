<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GatePassController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReturnItemController;

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

Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::put('/customers/payment', [CustomerController::class, 'receivePayment']);
Route::get('/customers/payments', [CustomerController::class, 'payments']);
Route::get('/customers/payments/{customerId}', [CustomerController::class, 'paymentsByCustomer']);


Route::get('/gatepasses', [GatePassController::class, 'index']);
Route::post('/gatepasses', [GatePassController::class, 'store']);
Route::put('/gatepasses/{id}', [GatePassController::class, 'update']);


Route::prefix('customer-orders')->group(function () {
    Route::get('/', [CustomerOrderController::class, 'index']);
    Route::post('/', [CustomerOrderController::class, 'store']);
    Route::put('/{id}', [CustomerOrderController::class, 'update']);
    Route::post('/new-order/{customerId}', [CustomerOrderController::class, 'newOrder']);
    Route::get('/item-profit', [CustomerOrderController::class, 'itemProfit']);
});


Route::prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::get('/{id}', [InvoiceController::class, 'show']);
    Route::post('/', [InvoiceController::class, 'store']);
    Route::put('/{id}', [InvoiceController::class, 'update']);
});

Route::prefix('items')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/', [ItemController::class, 'store']);
    Route::post('/filterWithDate', [ItemController::class, 'filterWithDate']);
    Route::put('/{id}', [ItemController::class, 'update']);
    Route::put('/stockAdd', [ItemController::class, 'addStock']);
});


Route::prefix('return-items')->group(function () {
    Route::get('/', [ReturnItemController::class, 'index']);
    Route::post('/', [ReturnItemController::class, 'store']);
    Route::put('/{id}', [ReturnItemController::class, 'update']);
});