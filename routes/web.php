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
Route::resource('/', 'loginController');// 第一個
//因為是登入 所以東西不能放在GET 我們這邊用POST
//any 是啥都可以 他不會特別去監控 你是get 還是post
//你要去哪都會經過路由 不能直接指定view
Route::any('verify', 'loginController@verifya')->name('verify');
Route::any('logout', 'loginController@logout')->name('logout');
Route::get('showboard', 'BoardController@showboard')->name('showboard')->middleware('AuthStatus');
Route::resource('personalinfor', 'personalinforController')->middleware('AuthStatus');
Route::resource('creatboard', 'BoardController')->middleware('AuthStatus');
//resource 他是同時有新修查改的route 所以 不用'HumanResourceController@index' 只需要給他controller就可以了
// 當連到該路由的時候HumanResource 他會判斷 你連到這個路由的時候 適用POST 還是 GET 來判斷你是哪個function
//像左邊第一個 他適用GET的方式 但是他啥資料都沒帶 他的行為欄位寫的是index 代表著首頁
//第三個 他是POST 表示你FROM或AJAX再送出時 action 需要寫post 他就會跑到store的function
//第四個 他是GET 帶參數 /photo/{我是參數} 如果接收到 他就會跑到Show
//引為route 我比較懶 所以我直接教你比較高階的作法 正常一開始都是
//Route::post('verify', 'loginController@verifya');像這樣
//Route::get('verify/{value}', 'loginController@verifya');這是帶傳參
//Route::resource('HumanResource', 'HumanResourceController');
Route::any('historytrippay', 'PayController@historytrippay')->name('historytrippay');
Route::any('newboard', 'BoardController@newboard')->name('newboard');
Route::resource('employees', 'HumanResourceController')->middleware('AuthStatus');


Route::post('search', 'HumanResourceController@search_empid')->name('search')->middleware('AuthStatus');
Route::resource('leavefake', 'leavefakeController')->middleware('AuthStatus');
Route::get('isholiday', 'leavefakeController@isholiday')->middleware('AuthStatus')->name('isholiday');
//你路徑 signleaveorder
Route::post('signleaveorder', 'leavefakeController@signleaveorder')->middleware('AuthStatus')->name('signleaveorder');
Route::post('searchdate', 'leavefakeController@sreachdate')->name('searchdate')->middleware('AuthStatus');
Route::get('finshorder', 'leavefakeController@finshorder')->name('finshorder')->middleware('AuthStatus');//秀出列表
Route::post('signfinsh', 'leavefakeController@signfinsh')->name('signfinsh')->middleware('AuthStatus');//審核
Route::post('sumleavedate', 'leavefakeController@sumleavedate')->name('sumleavedate')->middleware('AuthStatus');//審核
Route::any('showleaveorder', 'leavefakeController@showleaveorder')->name('showleaveorder')->middleware('AuthStatus');//個人當月某假別
Route::any('showleaveall', 'leavefakeController@showleaveall')->name('showleaveall')->middleware('AuthStatus');//秀出資料
Route::any('historysignfinsh', 'leavefakeController@historysignfinsh')->name('historysignfinsh')->middleware('AuthStatus');
Route::resource('vacation', 'vacationController')->middleware('AuthStatus');;//休假與請假系統串接
Route::resource('Pay', 'PayController')->middleware('AuthStatus');
Route::any('search_trip', 'PayController@search_trip')->name('search_trip')->middleware('AuthStatus');
Route::get('orderdetail/{p}', 'leavefakeController@orderdetail')->middleware('AuthStatus')->name('orderdetail');
Route::any('showtripsign', 'PayController@showtripsign')->name('showtripsign')->middleware('AuthStatus');





