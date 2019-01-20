<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ライブ記事一覧
Route::get('articles', 'ArticleController@index');

//ライブ記事詳細
Route::get('article/{id}', 'ArticleController@show');

//ライブ記事新規作成
Route::post('article', 'ArticleController@store');

//ライブ記事更新
Route::put('article', 'ArticleController@store');

//ライブ記事削除
Route::delete('article/{id}', 'ArticleController@destroy');