
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Protected shop pages
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard-data', [DashboardController::class, 'index'])
        ->name('dashboard.data');

    Route::resource('orders', OrderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);

    Route::get('/payments', function () {
        return view('payments.index');
    })->name('payments.page');

    Route::get('/payments-data', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::get('/payments/create', function () {
        return view('payments.create');
    })->name('payments.create');

    Route::get('/payments-create-data', [PaymentController::class, 'create'])
        ->name('payments.create.data');

    Route::post('/payments', [PaymentController::class, 'store'])
        ->name('payments.store');

    Route::get('/payments/{payment}', [PaymentController::class, 'show'])
        ->name('payments.show');

    Route::put('/payments/{payment}', [PaymentController::class, 'update'])
        ->name('payments.update');

    Route::get('/payments/{payment}/view', function ($payment) {
        return view('payments.show', [
            'paymentId' => $payment,
        ]);
    })->name('payments.view');

    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])
        ->name('payments.destroy');
});
