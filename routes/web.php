<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ContractorPaymentController;
use App\Http\Controllers\ContractorTaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SiteVisitController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // RBAC management
    Route::resource('users', UserController::class)->except('show')->middleware('permission:manage users');
    Route::resource('roles', RoleController::class)->except('show')->middleware('permission:manage roles');
    Route::resource('permissions', PermissionController::class)->except('show')->middleware('permission:manage permissions');

    // Audit logs (read-only)
    Route::get('audit-logs', [AuditLogController::class, 'index'])->middleware('permission:view audit logs')->name('audit-logs.index');
    Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])->middleware('permission:view audit logs')->name('audit-logs.show');

    // Planning & Gantt
    Route::middleware('permission:manage planning')->group(function () {
        Route::get('gantt', [TaskController::class, 'gantt'])->name('tasks.gantt');
        Route::resource('tasks', TaskController::class)->except('show');
    });

    // Property Management
    Route::middleware('permission:manage property')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::resource('towers', TowerController::class);
        Route::resource('floors', FloorController::class)->except('show');
        Route::resource('flats', FlatController::class)->except('show');
    });

    // Purchase
    Route::middleware('permission:manage purchase')->group(function () {
        Route::resource('vendors', VendorController::class)->except('show');
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::post('purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])
            ->middleware('permission:approve purchase')->name('purchase-orders.approve');
        Route::post('purchase-orders/{purchaseOrder}/reject', [PurchaseOrderController::class, 'reject'])
            ->middleware('permission:approve purchase')->name('purchase-orders.reject');
    });

    // Sales & CRM
    Route::middleware('permission:manage sales')->group(function () {
        Route::resource('customers', CustomerController::class)->except('show');
        Route::resource('leads', LeadController::class)->except('show');
        Route::resource('site-visits', SiteVisitController::class)->except('show');
        Route::resource('bookings', BookingController::class);
        Route::resource('installments', InstallmentController::class)->except('show');
        Route::resource('payments', PaymentController::class)->except('show');
    });

    // Contractors
    Route::middleware('permission:manage contractors')->group(function () {
        Route::resource('contractors', ContractorController::class)->except('show');
        Route::resource('contractor-tasks', ContractorTaskController::class)->except('show');
        Route::resource('attendances', AttendanceController::class)->except('show');
        Route::resource('contractor-payments', ContractorPaymentController::class)->except('show');
    });

    // Reports
    Route::middleware('permission:view reports')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
        Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('reports/{type}/export', [ReportController::class, 'export'])->name('reports.export');
    });

    // Settings
    Route::middleware('permission:manage settings')->group(function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
        Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
        Route::delete('settings/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');
    });
});
