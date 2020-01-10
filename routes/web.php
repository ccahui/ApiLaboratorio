<?php

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
use App\Http\Resources\AlumnoCollection;
use App\Models\Alumno;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/alumnos', function () {
    return new AlumnoCollection(Alumno::paginate());
});
