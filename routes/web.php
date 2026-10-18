<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // หน้า Dashboard หลัก
    Route::get('/dashboard', [RepairRequestController::class, 'index'])->name('dashboard');

    // 👤 Profile Routes (เพิ่มกลับเข้ามาแก้ Error ของ Navigation)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔧 เส้นทางระบบแจ้งซ่อม (Repair Requests)
    Route::prefix('repair-requests')->name('repair-requests.')->group(function () {
        Route::get('/create', [RepairRequestController::class, 'create'])->name('create');
        Route::post('/', [RepairRequestController::class, 'store'])->name('store');
        Route::get('/{repairRequest}', [RepairRequestController::class, 'show'])->name('show');
        Route::match(['post', 'patch'], '/{repairRequest}/assign', [RepairRequestController::class, 'assignTradesman'])->name('assign-tradesman');
        Route::match(['post', 'patch'], '/{repairRequest}/assign-tradesman', [RepairRequestController::class, 'assignTradesman'])->name('assign');
        Route::match(['post', 'patch'], '/{repairRequest}/status', [RepairRequestController::class, 'updateStatus'])->name('update-status');
    });
});

require __DIR__.'/auth.php';