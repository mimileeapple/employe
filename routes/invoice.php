<?php
Route::resource('invoice', 'invoiceController')->middleware('AuthStatus');
Route::any('newinvoice/{p}', 'invoiceController@newinvoice')->name('newinvoice')->middleware('AuthStatus');
Route::resource('packlist', 'PacklistController')->middleware('AuthStatus');
Route::any('newpacklist', 'PacklistController@newpacklist')->name('newpacklist')->middleware('AuthStatus');
Route::any('showmodelname', 'PacklistController@showmodelname')->name('showmodelname')->middleware('AuthStatus');
Route::any('packlistall', 'PacklistController@packlistall')->name('packlistall')->middleware('AuthStatus');
Route::get('showinvoice/{p}', 'PacklistController@showinvoice')->name('showinvoice')->middleware('AuthStatus');


