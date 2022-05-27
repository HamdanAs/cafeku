<?php

use App\Http\Controllers\ReportController;
use App\Http\Livewire\AddMenu;
use App\Http\Livewire\AdminDashboard;
use App\Http\Livewire\CashierDashboard;
use App\Http\Livewire\Category;
use App\Http\Livewire\EditMenu;
use App\Http\Livewire\Login;
use App\Http\Livewire\ManagerDashboard;
use App\Http\Livewire\ManagerMenu;
use App\Http\Livewire\ManagerReport;
use App\Http\Livewire\MenusReport;
use App\Http\Livewire\Register;
use App\Http\Livewire\SalesReport;
use App\Http\Livewire\Transaction;
use App\Http\Livewire\TransactionHistory;
use App\Http\Livewire\TransactionProcess;
use App\Http\Livewire\TransactionReportByCashier;
use App\Http\Livewire\TransactionReportByDate;
use App\Http\Livewire\User;
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

Route::middleware(['web', 'guest'])->group(function(){
    Route::get('/', Login::class);
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('role:admin')->group(function(){
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/user', User::class)->name('admin.user');
});

Route::middleware('role:manager')->group(function(){
    Route::get('/manager/dashboard', ManagerDashboard::class)->name('manager.dashboard');
    Route::get('/manager/category', Category::class)->name('manager.category');
    Route::get('/manager/menu', ManagerMenu::class)->name('manager.menu');
    Route::get('/manager/menu/add', AddMenu::class)->name('manager.menu.add');
    Route::get('/manager/menu/edit/{id}', EditMenu::class)->name('manager.menu.edit');

    Route::prefix('/manager/report')->group(function(){
        Route::get('/', ManagerReport::class)->name('manager.report');
        Route::get('/sales', SalesReport::class)->name('manager.report.sales');
        Route::get('/transaction/cashier', TransactionReportByCashier::class)->name('manager.report.transaction.cashier');
        Route::get('/transaction/pdf', [ReportController::class, 'transactionReport'])->name('manager.report.transaction.pdf');
        Route::get('/sales/pdf', [ReportController::class, 'salesReport'])->name('manager.report.sales.pdf');
    });
});

Route::middleware('role:cashier')->group(function(){
    Route::get('/cashier/dashboard', CashierDashboard::class)->name('cashier.dashboard');
    Route::get('/cashier/transaction', Transaction::class)->name('cashier.transaction');
    Route::get('/cashier/transaction/history', TransactionHistory::class)->name('cashier.transaction.history');
    Route::get('/cashier/transaction/process', TransactionProcess::class)->name('cashier.transaction.process');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';
