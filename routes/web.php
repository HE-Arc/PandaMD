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

Route::resource("folders", "FolderController", ["only"=>["show", "index"]]);

Route::get('files/{file}/generate', 'FileController@generate')->name('generate');
Route::get('files/{token}/download', 'FileController@download')->name('downloadPdfFile');
Route::get('files/{token}/isReady', 'FileController@isReady')->name('isReady');
Route::resource("files", "FileController", ["only" => ["show", "edit", "update"]]);