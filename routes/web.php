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

Route::get('/clientes', 'ClientesController@index')->name('clientes.index');
Route::get('/clientes/listar', 'ClientesController@listar')->name('clientes.listar');
Route::get('/clientes/novo', 'ClientesController@create')->name('clientes.novo');
Route::post('/clientes/salvar', 'ClientesController@store')->name('clientes.salvar');
Route::delete('/clientes/apagar/{id}', 'ClientesController@destroy')->name('clientes.apagar');
Route::get('/clientes/editar/{id}', 'ClientesController@edit')->name('clientes.editar');
Route::patch('/clientes/salvar/{id}', 'ClientesController@update')->name('clientes.atualizar');

// PRODUTOS
Route::get('/produtos', 'ProdutoController@indexView')->name('produtos.index');
Route::get('/produtos/listar', 'ProdutoController@listar')->name('produtos.listar');
Route::get('/produtos/novo', 'ProdutoController@create')->name('produtos.novo');
Route::post('/produtos/salvar', 'ProdutoController@store')->name('produtos.salvar');
Route::delete('/produtos/apagar/{id}', 'ProdutoController@destroy')->name('produtos.apagar');
Route::get('/produtos/editar/{id}', 'ProdutoController@edit')->name('produtos.editar');
Route::patch('/produtos/salvar/{id}', 'ProdutoController@update')->name('produtos.atualizar');

