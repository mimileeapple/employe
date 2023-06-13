<?php

Route::resource('empchina', 'EmpchinaController')->middleware('AuthStatus');
Route::resource('leavechina', 'leavechinaController')->middleware('AuthStatus');
Route::get('showleaveallchina', 'leavechinaController@showleaveallchina')->name('showleaveallchina')->middleware('AuthStatus');
Route::get('finshorderchina', 'leavechinaController@finshorderchina')->name('finshorderchina')->middleware('AuthStatus');
Route::get('signfinshchina', 'leavechinaController@signfinshchina')->name('signfinshchina')->middleware('AuthStatus');
Route::get('historysignfinshchina','leavechinaController@historysignfinshchina')->name('historysignfinshchina')->middleware('AuthStatus');
