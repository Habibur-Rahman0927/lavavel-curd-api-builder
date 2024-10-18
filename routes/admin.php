<?php

use App\Http\Controllers\Admin\CrudGeneratorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleHasPermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

Route::resource('user', UserController::class);
Route::get('user-list', [UserController::class, 'getDatatables'])->name('user-list');

Route::resource('role', RoleController::class);
Route::get('role-list', [RoleController::class, 'getDatatables'])->name('role-list');

Route::get('/crud-generator', [CrudGeneratorController::class, 'showModelForm'])->name('crud.generator.model.form');
Route::post('/crud-generator/generate-model', [CrudGeneratorController::class, 'generateModelWithMigration'])->name('crud.generator.model.generate');

Route::resource('permission', PermissionController::class);
Route::get('permission-list', [PermissionController::class, 'getDatatables'])->name('permission-list');

Route::resource('rolehaspermission', RoleHasPermissionController::class);
Route::get('rolehaspermission-list', [RoleHasPermissionController::class, 'getDatatables'])->name('rolehaspermission-list');