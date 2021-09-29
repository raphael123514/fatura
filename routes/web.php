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
    return view('index');
});


//CATEGORIAS

Route::get('/categorias', 'CategoriaController@index');
Route::get('/categorias/novo', 'CategoriaController@create');
Route::post('/categorias/salvar', 'CategoriaController@store');
Route::post('/categorias/salvar/{id}', 'CategoriaController@update');
Route::get('/categorias/apagar/{id}', 'CategoriaController@destroy');
Route::get('/categorias/editar/{id}', 'CategoriaController@edit');

// PRODUTOS

Route::get('/produtos', 'ProdutoController@indexView');
Route::get('/produtos/novo', 'ProdutoController@create');
Route::post('/produtos/salvar', 'ProdutoController@store');
Route::post('/produtos/salvar/{id}', 'ProdutoController@update');
Route::get('/produtos/apagar/{id}', 'ProdutoController@destroy');
Route::get('/produtos/editar/{id}', 'ProdutoController@edit');

