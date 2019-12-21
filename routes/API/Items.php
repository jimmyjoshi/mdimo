<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('items', 'APIItemsController@index')->name('items.index');
    Route::post('items/create', 'APIItemsController@create')->name('items.create');
    Route::post('items/edit', 'APIItemsController@edit')->name('items.edit');
    Route::post('items/show', 'APIItemsController@show')->name('items.show');
    Route::post('items/delete', 'APIItemsController@delete')->name('items.delete');
});
?>