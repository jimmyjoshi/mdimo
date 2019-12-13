<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('test', 'APITestController@index')->name('test.index');
    Route::post('test/create', 'APITestController@create')->name('test.create');
    Route::post('test/edit', 'APITestController@edit')->name('test.edit');
    Route::post('test/show', 'APITestController@show')->name('test.show');
    Route::post('test/delete', 'APITestController@delete')->name('test.delete');
});
?>