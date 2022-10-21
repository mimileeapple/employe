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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::resource('/', 'loginController');
//因為是登入 所以東西不能放在GET 我們這邊用POST
//any 是啥都可以 他不會特別去監控 你是get 還是post
Route::any('verify', 'loginController@verifya');
Route::resource('personalinfor', 'personalinforController');

//resource 他是同時有新修查改的route 所以 不用'HumanResourceController@index' 只需要給他controller就可以了
// 當連到該路由的時候HumanResource 他會判斷 你連到這個路由的時候 適用POST 還是 GET 來判斷你是哪個function
//像左邊第一個 他適用GET的方式 但是他啥資料都沒帶 他的行為欄位寫的是index 代表著首頁
//第三個 他是POST 表示你FROM或AJAX再送出時 action 需要寫post 他就會跑到store的function
//第四個 他是GET 帶參數 /photo/{我是參數} 如果接收到 他就會跑到Show
//引為route 我比較懶 所以我直接教你比較高階的作法 正常一開始都是
//Route::post('verify', 'loginController@verifya');像這樣
//Route::get('verify/{value}', 'loginController@verifya');這是帶傳參
//Route::resource('HumanResource', 'HumanResourceController');

Route::resource('employees', 'HumanResourceController');


