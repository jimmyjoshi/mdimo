<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::any('order', 'APIOrderController@index')->name('order.index');
    Route::post('order/create', 'APIOrderController@create')->name('order.create');
    Route::post('order/edit', 'APIOrderController@edit')->name('order.edit');
    Route::post('order/show', 'APIOrderController@show')->name('order.show');
    Route::post('order/delete', 'APIOrderController@delete')->name('order.delete');
});
?>