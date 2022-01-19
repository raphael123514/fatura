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


//CLIENTES

Route::get('/clientes', 'ClientesController@index');
Route::get('/clientes/novo', 'ClientesController@create');
Route::post('/clientes/salvar', 'ClientesController@store');
Route::post('/clientes/salvar/{id}', 'ClientesController@update');
Route::get('/clientes/apagar/{id}', 'ClientesController@destroy');
Route::get('/clientes/editar/{id}', 'ClientesController@edit');

// PRODUTOS
Route::get('/produtos', 'ProdutoController@indexView')->name('produtos.index');
Route::get('/produtos/listar', 'ProdutoController@listar')->name('produtos.listar');
Route::get('/produtos/novo', 'ProdutoController@create')->name('produtos.novo');
Route::post('/produtos/salvar', 'ProdutoController@store')->name('produtos.salvar');
Route::delete('/produtos/apagar/{id}', 'ProdutoController@destroy')->name('produtos.apagar');
Route::get('/produtos/editar/{id}', 'ProdutoController@edit')->name('produtos.editar');
Route::patch('/produtos/salvar/{id}', 'ProdutoController@update')->name('produtos.update');

