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

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\CSVController;

//本ダッシュボード表示
Route::get('/', 'BooksController@index')->name('books.index');;

// 検索機能追加
Route::get('/search', 'BooksController@index')->name('search');

//登録処理
Route::post('/books','BooksController@store');

// 本の詳細表示
Route::get('/books/{book}', 'BooksController@show')->name('books.show');


//更新画面
Route::get('/booksedit/{books}','BooksController@edit');

//更新処理
Route::post('/books/update','BooksController@update');

//本を削除
Route::delete('/book/{book}','BooksController@destroy');

//CSVインポート/ダウンロード機能
Route::get('/csv/download', [CSVController::class, 'download'])->name('csv.download');
Route::post('/csv/import', [CSVController::class, 'import'])->name('csv.import');

//Auth
Auth::routes();
Route::get('/home', 'BooksController@index')->name('home');

