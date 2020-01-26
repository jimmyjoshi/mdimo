<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('orderdetail', 'APIOrderDetailController@index')->name('orderdetail.index');
    Route::post('orderdetail/create', 'APIOrderDetailController@create')->name('orderdetail.create');
    Route::post('orderdetail/edit', 'APIOrderDetailController@edit')->name('orderdetail.edit');
    Route::post('orderdetail/show', 'APIOrderDetailController@show')->name('orderdetail.show');
    Route::post('orderdetail/delete', 'APIOrderDetailController@delete')->name('orderdetail.delete');
});
?>