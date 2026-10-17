<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/dashboard-data', [DashboardController::class, 'index'])
    ->name('dashboard.data');
Route::resource('orders', OrderController::class);
Route::resource('categories',CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);
Route::get('/orders/{order}', [OrderController::class, 'show'])
    ->name('orders.show');


// Payments List page
Route::get('/payments', function () {
    return view('payments.index');
})->name('payments.page');

// AJAX: Load payments list data
Route::get('/payments-data', [PaymentController::class, 'index'])
    ->name('payments.index');

// Display Add Payment form
Route::get('/payments/create', function () {
    return view('payments.create');
})->name('payments.create');

// AJAX: Load orders for dropdown
Route::get('/payments-create-data', [PaymentController::class, 'create'])
    ->name('payments.create.data');

// AJAX: Save payment
Route::post('/payments', [PaymentController::class, 'store'])
    ->name('payments.store');

// View payment details
Route::get('/payments/{payment}', [PaymentController::class, 'show'])
    ->name('payments.show');

// Update payment using AJAX
Route::put('/payments/{payment}', [PaymentController::class, 'update'])
    ->name('payments.update');

Route::get('/payments/{payment}/view', function ($payment) {
    return view('payments.show', [
        'paymentId' => $payment
    ]);
})->name('payments.view');
// Delete payment using AJAX
Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])
    ->name('payments.destroy');