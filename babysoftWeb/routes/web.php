<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VentaController;


use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('venta/pdf', [VentaController::class, 'pdf'])->name('venta.pdf');

Route::resource('clientes', App\Http\Controllers\clienteController::class)->middleware('can:Acceso a los Clientes');
Route::resource('proveedores', App\Http\Controllers\proveedoreController::class)->middleware('can:Acceso a los Proveedores');
Route::resource('productos', App\Http\Controllers\productoController::class)->middleware('can:Acceso a los Productos');
Route::post('/nuevo-producto', [ProductoController::class, 'store']);
Route::resource('productos', App\Http\Controllers\productoController::class)->middleware('can:Acceso a los Productos');
Route::resource('compras', App\Http\Controllers\compraController::class)->middleware('can:Acceso a las Compras');
Route::resource('ventas', App\Http\Controllers\ventaController::class)->middleware('can:Acceso a las Ventas');

Route::resource('/roles', RoleController::class)->middleware('can:Acceso a la Configuración');



Route::resource('users', UserController::class)->middleware('can:Acceso a la Configuración');
Route::post('/usuarios/{id}/toggle-active', [UserController::class, 'toggleActive'])->name('usuarios.toggleActive');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit')->middleware('can:Acceso a la Configuración');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update')->middleware('can:Acceso a la Configuración');
Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create')->middleware('can:Acceso a la Configuración');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store')->middleware('can:Acceso a la Configuración');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy')->middleware('can:Acceso a la Configuración');

Route::get('/backup', [BackupController::class, 'createBackup'])->name('backup.create');

Route::match(['get'], '/{home?}', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Route::post('users/{id}/toggle-active', 'UserController@toggleActive');
