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
Route::any('historytrippay', 'PayController@historytrippay')->name('historytrippay')->middleware('AuthStatus');
Route::any('newboard', 'BoardController@newboard')->name('newboard')->middleware('AuthStatus');
Route::any('showpic', 'BoardController@showpic')->name('showpic')->middleware('AuthStatus');

Route::resource('employees', 'HumanResourceController')->middleware('AuthStatus');

Route::any('showpicsign', 'HumanResourceController@showpicsign')->name('showpicsign')->middleware('AuthStatus');
Route::post('uploadpicsign', 'HumanResourceController@uploadpicsign')->name('uploadpicsign')->middleware('AuthStatus');

Route::post('search', 'HumanResourceController@search_empid')->name('search')->middleware('AuthStatus');
Route::resource('leavefake', 'leavefakeController')->middleware('AuthStatus');
Route::get('isholiday', 'leavefakeController@isholiday')->middleware('AuthStatus')->name('isholiday');
//你路徑 signleaveorder
Route::get('workinfo', 'leavefakeController@workinfo')->middleware('AuthStatus')->name('workinfo');
Route::post('signleaveorder', 'leavefakeController@signleaveorder')->middleware('AuthStatus')->name('signleaveorder');
Route::any('searchdate', 'leavefakeController@sreachdate')->name('searchdate')->middleware('AuthStatus');
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
Route::resource('checkin', 'checkinController')->middleware('AuthStatus');
Route::any('search_checkin', 'checkinController@search_checkin')->name('search_checkin')->middleware('AuthStatus');
Route::any('showchecksign', 'checkinController@showchecksign')->name('showchecksign')->middleware('AuthStatus');

Route::any('showcheckinoflate', 'checkinController@showcheckinoflate')->name('showcheckinoflate')->middleware('AuthStatus');
Route::any('checkinoflate', 'checkinController@checkinoflate')->name('checkinoflate')->middleware('AuthStatus');

Route::any('selectmonthshowcheckintotal', 'checkinController@selectmonthshowcheckintotal')->name('selectmonthshowcheckintotal')->middleware('AuthStatus');
Route::any('selectmonth', 'checkinController@selectmonth')->name('selectmonth')->middleware('AuthStatus');

Route::any('leaveorderdatilday', 'checkinController@leaveorderdatilday')->name('leaveorderdatilday')->middleware('AuthStatus');
Route::any('signcheckin', 'checkinController@signcheckin')->name('signcheckin')->middleware('AuthStatus');
Route::any('showallemplist', 'checkinController@showallemplist')->name('showallemplist')->middleware('AuthStatus');
Route::any('search_checkemp', 'checkinController@search_checkemp')->name('search_checkemp')->middleware('AuthStatus');
//都有 但是基本惠要求會用resource 一班的用法很多 他們會在一班的路由裡面加規則 你現在是都沒加 ㄨ

Route::resource('material', 'MaterialController')->middleware('AuthStatus');
Route::resource('partdata', 'PartDataController')->middleware('AuthStatus');
Route::resource('customer', 'CustomerController')->middleware('AuthStatus');
Route::any('searchcustomer','CustomerController@searchcustomer')->name('searchcustomer')->middleware('AuthStatus');
Route::any('materialExport','MaterialController@materialExport')->name('materialExport')->middleware('AuthStatus');
Route::any('historysign','checkinController@historysign')->name('historysign')->middleware('AuthStatus');
Route::any('showpartdata', 'PartDataController@showpartdata')->name('showpartdata')->middleware('AuthStatus');
Route::resource('custPI', 'custPIController')->middleware('AuthStatus');
Route::any('searchcust', 'custPIController@searchcust')->name('searchcust')->middleware('AuthStatus');
Route::any('findbankdata', 'custPIController@findbankdata')->name('findbankdata')->middleware('AuthStatus');
Route::any('searchcompanyid', 'custPIController@searchcompanyid')->name('searchcompanyid')->middleware('AuthStatus');
Route::any('uploadpi', 'custPIController@uploadpi')->name('uploadpi')->middleware('AuthStatus');
Route::any('signpi/{p}', 'custPIController@signpi')->name('signpi')->middleware('AuthStatus');
Route::resource('pispace', 'PIspaceController')->middleware('AuthStatus');
Route::any('showpispace/{p}', 'PIspaceController@showpispace')->name('showpispace')->middleware('AuthStatus');

//這也有規則 規則是AuthStatus 我當初寫的是 如果session的會員不見了  他會到登入頁面 還有很多規則 這是比較核心的


//像這種的 他有在中介曾 增加規則 叫做WEB 如果有達成WEB的規則 路由才能連線
//Route::group(['middleware' => ['web']], function () {
//    //
//});


