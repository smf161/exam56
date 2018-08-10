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

//第一種
// Route::get('/', function () {
//     return view('welcome')
//         ->with('name', 'tad')
//         ->with('say', '嗨！');
// });

//第二種
// Route::get('/', function () {
//     $data = ['name' => 'tad', 'say' => '~hi~'];
//     return view('welcome', $data);
// });

//第三種
// Route::get('/', function () {
//     return view('welcome',  ['name' => 'tad', 'say' => '~hi~']);
// });

Route::pattern('exam', '[0-9]+');
Route::pattern('topic', '[0-9]+');
Route::pattern('test', '[0-9]+');

//第四種
Route::get('/', 'ExamController@index')->name('index');

Auth::routes();

Route::get('/home', 'ExamController@index')->name('home');

// Route::get('/exam/create', function () {
//     return view('exam.create');
// })->name('exam.create');

Route::get('/exam', 'ExamController@index')->name('exam.index'); //列表
Route::get('/exam/{exam}', 'ExamController@show')->name('exam.show'); //讀出單一測驗
Route::get('/exam/create', 'ExamController@create')->name('exam.create');

Route::post('/exam', 'ExamController@store')->name('exam.store'); //寫入資料庫

Route::get('/exam/{exam}/edit', 'ExamController@edit')->name('exam.edit'); //編輯

Route::patch('/exam/{exam}', 'ExamController@update')->name('exam.update'); //更新

Route::delete('/exam/{exam}', 'ExamController@destroy')->name('exam.destroy'); //刪除測驗

Route::post('/topic', 'TopicController@store')->name('topic.store'); //寫入題目

Route::get('/topic/{topic}/edit', 'TopicController@edit')->name('topic.edit'); //編輯題目

Route::patch('/topic/{topic}', 'TopicController@update')->name('topic.update'); //更新題目

Route::delete('/topic/{topic}', 'TopicController@destroy')->name('topic.destroy'); //刪除題目

Route::post('/test', 'TestController@store')->name('test.store'); //寫入答案

Route::get('/test/{test}', 'TestController@show')->name('test.show'); //寫入學生作答

// 處理表單，導向至 NTPC OpenID 登入
Route::post('auth/login/openid', 'OpenIDController@ntpcopenid')->name('ntpcopenid');

// OpenID 導回
Route::get('auth/login/openid', 'OpenIDController@get_ntpcopenid')->name('get_ntpcopenid');
