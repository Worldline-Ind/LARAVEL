<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/start', [Controllers\paymentController::class, 'index']);//for fetch
Route::post('/pay', [Controllers\paymentController::class, 'payProcess']);
Route::post('/checkout', [Controllers\paymentController::class, 'checkout']);
Route::post('/start', [Controllers\paymentController::class, 'index'])->name('start');//for create , update
//OFFLINE VERIFICATION------------------------------------------------------
Route::get('/offline_verification', function()
    {
        return view ('offline_verification'); 
    })->name('offline_verification');
Route::post('/offline_request', [Controllers\paymentController::class, 'offline_request']);

//RECONCILIATION ------------------------------------------------------------
Route::get('/reconciliation', function()
    {
        return view ('reconciliation'); 
    })->name('reconciliation');
Route::post('/reconcile_request', [Controllers\paymentController::class, 'reconcile_request']);

//REFUND ------------------------------------------------------------
Route::get('/refund', function()
    {
        return view ('refund'); 
    })->name('refund');
Route::post('/refund_request', [Controllers\paymentController::class, 'refund_request']);

//mandate varification ------------------------------------------------------------
Route::get('/mandate_verification', function()
    {
        return view ('mandate_verification'); 
    })->name('mandate_verification');
Route::post('/mandate_verification_request', [Controllers\paymentController::class, 'mandate_verification_request']);


//transaction scheduling ------------------------------------------------------------
Route::get('/transaction_scheduling', function()
    {
        return view ('transaction_scheduling'); 
    })->name('transaction_scheduling');
Route::post('/transaction_scheduling_request', [Controllers\paymentController::class, 'transaction_scheduling_request']);

//transaction verification ------------------------------------------------------------
Route::get('/transaction_verification', function()
    {
        return view ('transaction_verification'); 
    })->name('transaction_verification');
Route::post('/transaction_verification_request', [Controllers\paymentController::class, 'transaction_verification_request']);


//mandate  deactivation -------------------
Route::get('/mandate_deactivation', function()
    {
        return view ('mandate_deactivation'); 
    })->name('mandate_deactivation');
Route::post('/mandate_deactivation_request', [Controllers\paymentController::class, 'mandate_deactivation_request']);

//stop  payment -------------------
Route::get('/stop_payment', function()
    {
        return view ('stop_payment'); 
    })->name('stop_payment');
Route::post('/stop_payment_request', [Controllers\paymentController::class, 'stop_payment_request']);

//admin part
Route::get('/admin', function(){ return view ('admin'); })->name('admin');
Route::post('/submit_request', [Controllers\paymentController::class, 'submit_request']);

Route::get('/s2s', [Controllers\paymentController::class, 's2s']);




