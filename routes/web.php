<?php

use App\Http\Controllers\EditorialController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroVentaController;
use App\Models\LibroVenta;
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

Route::get('/', function () {
    return view('welcome');
});
//Seccion de Editorial
Route::get('/editorial', [EditorialController::class, 'index']);
Route::post('/editorial/save', [EditorialController::class, 'save']);
Route::post('/editorial/delete', [EditorialController::class, 'delete']);

//Seccion de Autores
Route::get('/autor', [AutorController::class, 'index']);
Route::get('/autores/{id}', [AutorController::class, 'autores']);
Route::post('/autor/save', [AutorController::class, 'save']);
Route::post('/autor/delete', [AutorController::class, 'delete']);

//Seccion de Libros
Route::get('/libro', [LibroVentaController::class, 'index']);
Route::post('/libro/save', [LibroVentaController::class, 'save']);
Route::post('/libro/delete', [LibroVentaController::class, 'delete']);