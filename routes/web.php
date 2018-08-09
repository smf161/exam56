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

Route::post('/topic', 'TopicController@store')->name('topic.store'); //寫入題目
