<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::view('/mimascota', 'mimascota')->name('mimascota');

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'redirect'])->name('facebook.login');
Route::get('/facebook/auth/callback', [App\Http\Controllers\Auth\FacebookController::class, 'callback']);
Route::post('/mascotas/continuar', [App\Http\Controllers\MascotasController::class, 'store'])->name('mascotas.store');
Route::put('mascotas/actualizar', [App\Http\Controllers\MascotasController::class, 'update'])->name('mascotas.update');
Route::post('/mascotas/actualizacion', [App\Http\Controllers\MascotasController::class, 'actualizar'])->name('mascotas.actualizar');
Route::post('/mascotas/terminar', [App\Http\Controllers\MascotasController::class, 'cartilla'])->name('mascotas.cartilla');
Route::get('/mascotas/mostrar', [App\Http\Controllers\MascotasController::class, 'index'])->name('mascotas.mostrar');
Route::get('/mascotas/razas', [App\Http\Controllers\MascotasController::class, 'razas'])->name('mascotas.razas');
Route::delete('/mascotas/eliminar/{id}', [App\Http\Controllers\MascotasController::class, 'destroy'])->name('mascotas.eliminar');
Route::post('/mascotas/actual', [App\Http\Controllers\MascotaActualController::class, 'store'])->name('mascotas.actual');
Route::post('match/enviar', [App\Http\Controllers\MatchController::class, 'store'])->name('match.enviar');
Route::post('match/aceptar', [App\Http\Controllers\MatchController::class, 'update'])->name('match.aceptar');
Route::post('match/rechazar', [App\Http\Controllers\MatchController::class, 'rechazar'])->name('match.rechazar');
Route::post('/match/cancelar', [App\Http\Controllers\MatchController::class, 'cancelar'])->name('match.cancelar');
Route::get('/especies/mostrar', [App\Http\Controllers\EspeciesController::class, 'index'])->name('especies.mostrar');
Route::post('/consejos/mostrar', [App\Http\Controllers\ConsejosController::class, 'conseguirConsejos'])->name('consejos.mostrar');
Route::post('/adiestramiento/mostrar', [App\Http\Controllers\AdiestramientosController::class, 'conseguirAdiestramiento'])->name('adiestramiento.mostrar');
Route::post('adiestramiento/nuevo', [App\Http\Controllers\AdiestramientosController::class, 'store'])->name('adiestramiento.nuevo');
Route::post('adiestramiento/{id}', [App\Http\Controllers\AdiestramientosController::class, 'show'])->name('adiestramiento.show');

Route::post('/vacunas', [App\Http\Controllers\VacunasController::class, 'vacunas'])->name('mostrar.vacunas');