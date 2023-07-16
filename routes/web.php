<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/payment/initiate', [ PaymentController::class ,  'initiatePayment']);
Route::post('/payment/ipn', [ PaymentController::class , 'handleIPN']);
// Route::get('success/payment/' , [PaymentController::class , 'successReq']);
Route::get('/success/payment', function () {
   
    $transId = request()->query('transId');
   dd("Success Payment Route. TransId: $transId") ;
});
