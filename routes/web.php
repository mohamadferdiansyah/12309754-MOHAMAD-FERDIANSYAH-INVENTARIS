<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowedItemsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemStockController;
use App\Http\Controllers\ReturnedItemController;
use App\Http\Controllers\UserController;
use App\Models\BorrowedItem;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/', [ItemCategoryController::class, 'index'])->name('categories.index');
            Route::get('/create', [ItemCategoryController::class, 'create'])->name('categories.create');
            Route::post('/', [ItemCategoryController::class, 'store'])->name('categories.store');
            Route::get('/{category}/edit', [ItemCategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/{category}', [ItemCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/{category}', [ItemCategoryController::class, 'destroy'])->name('categories.destroy');
        });

        Route::prefix('items')->group(function () {
            Route::get('/create', [ItemStockController::class, 'create'])->name('items.create');
            Route::post('/', [ItemStockController::class, 'store'])->name('items.store');
            Route::get('/{item}/edit', [ItemStockController::class, 'edit'])->name('items.edit');
            Route::put('/{item}', [ItemStockController::class, 'update'])->name('items.update');
            Route::delete('/{item}', [ItemStockController::class, 'destroy'])->name('items.destroy');
            Route::get('/export/excel', [ItemStockController::class, 'exportExcel'])->name('items.export.excel');
        });

        Route::prefix('users')->group(function () {
            Route::get('/admin', [UserController::class, 'adminsIndex'])->name('users.admin');
            Route::get('/operator', [UserController::class, 'operatorsIndex'])->name('users.operator');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('/admin/export/excel', [UserController::class, 'exportAdminsExcel'])->name('users.admin.export.excel');
            Route::get('/operator/export/excel', [UserController::class, 'exportOperatorsExcel'])->name('users.operator.export.excel');
            Route::put('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        });
    });

    Route::middleware('role:staff')->group(function () {
        Route::prefix('lendings')->group(function () {
            Route::get('/create', [BorrowedItemsController::class, 'create'])->name('lendings.create');
            Route::post('/', [BorrowedItemsController::class, 'store'])->name('lendings.store');
            Route::delete('/{item}', [BorrowedItemsController::class, 'destroy'])->name('lendings.destroy');
            Route::get('/export/excel', [BorrowedItemsController::class, 'exportExcel'])->name('lendings.export.excel');
            Route::post('/{item}/returned', [ReturnedItemController::class, 'returned'])->name('lendings.returned');
            Route::get('/{item}/receipt', [BorrowedItemsController::class, 'downloadReceipt'])->name('lendings.download-receipt');
        });
    });

    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/items', [ItemStockController::class, 'index'])->name('items.index');
        Route::get('/lendings', [BorrowedItemsController::class, 'index'])->name('lendings.index');

        Route::prefix('users')->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        });
    });
});
