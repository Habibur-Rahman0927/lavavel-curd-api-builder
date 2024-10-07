<?php

use App\Http\Controllers\Admin\CrudGeneratorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

Route::resource('user', UserController::class);
Route::get('user-list', [UserController::class, 'getDatatables'])->name('user-list');

Route::get('/crud-generator', [CrudGeneratorController::class, 'showModelForm'])->name('crud.generator.model.form');
Route::post('/crud-generator/generate-model', [CrudGeneratorController::class, 'generateModelWithMigration'])->name('crud.generator.model.generate');