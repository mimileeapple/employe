<?php

Route::resource('payoffice', 'PayofficeController')->middleware('AuthStatus');
Route::any('searchpaytype', 'PayofficeController@searchpaytype')->name('searchpaytype')->middleware('AuthStatus');
