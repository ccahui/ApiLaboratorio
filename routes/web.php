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


Route::get('/', function () {
    return view('welcome');
});
Route::get('/cursos/laboratorios', 'CursoController@index');

Route::post('/alumnos/matricular', 'AlumnoController@matricular');

Route::get('/laboratorios/{id}/alumnos', 'LaboratorioController@alumnos');
Route::get('/profesores/{id}/laboratorios', 'ProfesorController@laboratorios');
Route::get('/alumnos/{id}/laboratorios', 'AlumnoController@laboratorios');
Route::get('/cursos/{id}/laboratorios', 'CursoController@laboratorios');

Route::apiResource('alumnos','API\AlumnoController');
Route::apiResource('profesores','API\ProfesorController');
Route::apiResource('cursos','API\CursoController');
Route::apiResource('grupos','API\GrupoController');
Route::apiResource('laboratorios','API\LaboratorioController');
Route::apiResource('matriculas','API\MatriculaController');

