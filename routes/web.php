<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantRequestController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])
    ->name('dashboard.analytics');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// TENANT ROUTES
Route::middleware(['auth'])->group(function () {
    Route::post('maintenance', [MaintenanceRequestController::class, 'store'])
        ->name('maintenance.store');
});

// ADMIN / MANAGER ROUTES
Route::middleware(['auth'])->group(function () {
    Route::resource('properties', PropertyController::class);
    Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->name('properties.show');

    Route::resource('units', UnitController::class)->except(['create', 'edit', 'show']);
    Route::resource('tenants', TenantController::class)->except(['create', 'edit']);
    Route::get('tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
    Route::resource('leases', LeaseController::class)->except(['create', 'edit', 'show']);
    Route::resource('payments', PaymentController::class)->only(['index', 'store', 'destroy']);
    Route::resource('maintenance', MaintenanceRequestController::class)->except(['create', 'edit', 'show', 'store']);
    Route::get('maintenance/{maintenance}', [MaintenanceRequestController::class, 'show'])
        ->name('maintenance.show');

    Route::patch('maintenance/{maintenance}/update-status', [MaintenanceRequestController::class, 'updateStatus'])
        ->name('maintenance.updateStatus');

    Route::post('maintenance/{maintenance}/response', [MaintenanceRequestController::class, 'response'])
        ->name('maintenance.response');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    Route::get('reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.exportPDF');

    Route::resource('requests', TenantRequestController::class)->except(['create', 'edit', 'show', 'store']);
    Route::get('requests/{requests}', [TenantRequestController::class, 'show'])
        ->name('requests.show');

    Route::patch('requests/{requests}/update-status', [TenantRequestController::class, 'updateStatus'])
        ->name('requests.updateStatus');

    Route::post('requests/{requests}/response', [TenantRequestController::class, 'response'])
        ->name('requests.response');
        Route::get('/inquiries', [PropertyController::class, 'adminIndex'])
            ->name('inquiries.index');
        Route::get('/inquiries/create', [PropertyController::class, 'createInquiry'])->name('inquiries.create');
Route::post('/inquiries', [PropertyController::class, 'storeInquiry'])->name('inquiries.store');
    Route::get('/tenant/profile', [TenantController::class, 'editTenantProfile'])->name('tenants.profile');
    Route::post('/tenant/profile', [TenantController::class, 'updateTenantProfile'])->name('tenant.profile.update');
});

// ADMIN-ONLY
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('roles-permissions', [RolePermissionController::class, 'index'])->name('roles_permissions.index');
    Route::post('roles-permissions/{user}/update-permissions', [RolePermissionController::class, 'updatePermissions'])->name('roles_permissions.updatePermissions');
    Route::post('roles-permissions/{user}/update-roles', [RolePermissionController::class, 'updateRoles'])->name('roles_permissions.updateRoles');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
});

require __DIR__ . '/auth.php';
