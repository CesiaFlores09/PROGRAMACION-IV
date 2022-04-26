<?php

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
Route::view('/mascotas', 'mascotas');

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'redirect'])->name('facebook.login');
Route::get('/facebook/auth/callback', [App\Http\Controllers\Auth\FacebookController::class, 'callback']);
// Route::get('/mascotas', [App\Http\Controllers\MascotasController::class, 'index'])->name('mascotas');
Route::post('/mascotas/continuar', [App\Http\Controllers\MascotasController::class, 'store'])->name('mascotas.store');
Route::get('/mascotas/actualizar', [App\Http\Controllers\MascotasController::class, 'update'])->name('mascotas.update');
Route::post('/mascotas/terminar', [App\Http\Controllers\MascotasController::class, 'cartilla'])->name('mascotas.cartilla');
