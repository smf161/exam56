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

//第四種
Route::get('/', function () {
    $name = 'tad';
    $say  = '~hi~';

    return view('welcome', compact('name', 'say'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
