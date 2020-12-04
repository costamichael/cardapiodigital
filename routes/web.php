<?php

//use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/',             'HomeController@index')->name('home');
Route::get('/home',         'HomeController@index')->name('home');
Route::get('/tema/{tema}',  'HomeController@tema')->name('home.tema');
Route::get('/modo/{modo_imagem_texto}',  'HomeController@modo_imagem_texto')->name('home.modo_imagem_texto');
Route::get('/buscar/',      'HomeController@buscar')->name('home.buscar');
Route::get('/buscarinsumo/','HomeController@buscarinsumo')->name('home.buscarinsumo');

////////////////////////////////////////////////////////////////////////////
////ROTAS DO ADMINISTRADOR /////////////////////////////////////////////////
Route::get('/admin',    'AdminController@index')->name('admin');

Route::group(['prefix'=>'admin/produtos','as'=>'admin.produtos.'], function(){
    Route::get('/',             ['as' => 'index',   'uses' => 'ProdutosController@index']);
    Route::get('/exibir/{id}',  ['as' => 'exibir',  'uses' => 'ProdutosController@show']);
    Route::get('/criar',        ['as' => 'criar',   'uses' => 'ProdutosController@create']);
    Route::post('/store',       ['as' => 'store',   'uses' => 'ProdutosController@store']);
    Route::get('/editar/{id}',  ['as' => 'editar',  'uses' => 'ProdutosController@edit']);
    Route::post('/update/{id}', ['as' => 'update',  'uses' => 'ProdutosController@update']);
    Route::get('/del_img/{id}', ['as' => 'del_img', 'uses' => 'ProdutosController@excluir_imagem']);
    Route::post('/excluir/{id}',['as' => 'destroy', 'uses' => 'ProdutosController@destroy']);
    Route::post('/ordem',       ['as' => 'ordem',   'uses' => 'ProdutosController@ordem']);
    Route::get('/editcat/{id}', ['as' => 'editcat', 'uses' => 'ProdutosController@editcat']);
    Route::post('/updcat/{id}', ['as' => 'updcat',  'uses' => 'ProdutosController@updcat']);
});

Route::group(['prefix'=>'admin/categorias','as'=>'admin.categorias.'], function(){
    Route::get('/',             ['as' => 'index',   'uses' => 'CategoriasController@index']);
    Route::get('/criar',        ['as' => 'criar',   'uses' => 'CategoriasController@create']);
    Route::post('/store',       ['as' => 'store',   'uses' => 'CategoriasController@store']);
    Route::get('/editar/{id}',  ['as' => 'editar',  'uses' => 'CategoriasController@edit']);
    Route::post('/update/{id}', ['as' => 'update',  'uses' => 'CategoriasController@update']);
    Route::post('/excluir/{id}',['as' => 'destroy', 'uses' => 'CategoriasController@destroy']);
    Route::post('/ordem',       ['as' => 'ordem',   'uses' => 'CategoriasController@ordem']);
    Route::post('/ajaxcat',     ['as' => 'ajaxcat', 'uses' => 'CategoriasController@ajaxcat']);
});

Route::group(['prefix'=>'admin/insumos','as'=>'admin.insumos.'], function(){
    Route::get('/',                         ['as' => 'index',   'uses'          => 'InsumosController@index']);
    Route::get('/criar',                    ['as' => 'criar',   'uses'          => 'InsumosController@create']);
    Route::post('/store',                   ['as' => 'store',   'uses'          => 'InsumosController@store']);
    Route::get('/editar/{id}',              ['as' => 'editar',  'uses'          => 'InsumosController@edit']);
    Route::post('/update/{id}',             ['as' => 'update',  'uses'          => 'InsumosController@update']);
    Route::get('/del_img/{id}',             ['as' => 'del_img', 'uses'          => 'InsumosController@excluir_imagem']);
    Route::post('/ordem',                   ['as' => 'ordem',   'uses'          => 'InsumosController@ordem']);
    Route::post('/excluir/{id}',            ['as' => 'destroy', 'uses'          => 'InsumosController@destroy']);
    Route::post('/excluir_autorize/{id}',   ['as' => 'destroy_autorize', 'uses' => 'InsumosController@destroy_autorize']);
    Route::post('/ajaxinsumos',             ['as' => 'ajaxinsumos', 'uses'      => 'InsumosController@ajaxinsumos']);
});
