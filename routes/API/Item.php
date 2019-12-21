<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::any('item', 'APIItemController@index')->name('item.index');
    Route::post('item/create', 'APIItemController@create')->name('item.create');
    Route::post('item/edit', 'APIItemController@edit')->name('item.edit');
    Route::post('item/show', 'APIItemController@show')->name('item.show');
    Route::post('item/delete', 'APIItemController@delete')->name('item.delete');
});
?>