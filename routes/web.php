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

Route::get('/clientes', 'ClienteController@index')->name('clientes.index');
Route::get('/clientes/listar', 'ClienteController@listar')->name('clientes.listar');
Route::get('/clientes/faturas/listar', 'ClienteController@listarFatura')->name('clientes.faturas.listar');
Route::delete('/clientes/faturas/remove/{id}', 'ClienteController@removeFatura')->name('produtos.faturas.remover');
Route::get('/clientes/produtos/listarProdutos', 'ClienteController@listarProdutos')->name('clientes.listarProdutos');
Route::get('/clientes/novo', 'ClienteController@create')->name('clientes.novo');
Route::post('/clientes/salvar', 'ClienteController@store')->name('clientes.salvar');
Route::delete('/clientes/apagar/{id}', 'ClienteController@destroy')->name('clientes.apagar');
Route::get('/clientes/editar/{id}', 'ClienteController@edit')->name('clientes.editar');
Route::patch('/clientes/salvar/{id}', 'ClienteController@update')->name('clientes.atualizar');

// PRODUTOS
Route::get('/produtos', 'ProdutoController@indexView')->name('produtos.index');
Route::get('/produtos/listar', 'ProdutoController@listar')->name('produtos.listar');
Route::get('/produtos/autocomplete', 'ProdutoController@autocomplete')->name('produtos.autocomplete');
Route::post('/produtos/faturas/geraValorFatura', 'ProdutoController@geraValorFatura')->name('produtos.faturas.valor');
Route::get('/produtos/novo', 'ProdutoController@create')->name('produtos.novo');
Route::post('/produtos/salvar', 'ProdutoController@store')->name('produtos.salvar');
Route::delete('/produtos/apagar/{id}', 'ProdutoController@destroy')->name('produtos.apagar');
Route::get('/produtos/editar/{id}', 'ProdutoController@edit')->name('produtos.editar');
Route::patch('/produtos/salvar/{id}', 'ProdutoController@update')->name('produtos.atualizar');

