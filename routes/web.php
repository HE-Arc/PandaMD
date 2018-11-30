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

Route::get("/", "HomeController@index")->name('home');

Auth::routes();

Route::resource("folders", "FolderController", ["except"=>["create"]]);

Route::get('files/{file}/generate', 'FileController@generate')->name('generate');

Route::resource("files", "FileController", ["except" => ["index","create","store"]]);
Route::put("files/{file}/rename", "FileController@changeName")->name('changeFileName');
Route::put("files/{file}/changeright", "FileController@changeRight")->name('changeRight');
Route::get('files/{token}/download', 'FileController@download')->name('downloadPdfFile');
Route::get('files/{token}/isReady', 'FileController@isReady')->name('isReady');
Route::get('files/', 'FileController@newFile')->name('newFile');
Route::put('files/{file}/changefilefolderid','FileController@changeFileFolder')->name('changeFileFolderId');
Route::put('folders/{folder}/changefolderfolderid','FolderController@changeFolderFolder')->name('changeFolderFolderId');


