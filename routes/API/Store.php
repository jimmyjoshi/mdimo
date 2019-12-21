<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('store', 'APIStoreController@index')->name('store.index');
    Route::post('store/create', 'APIStoreController@create')->name('store.create');
    Route::post('store/edit', 'APIStoreController@edit')->name('store.edit');
    Route::post('store/show', 'APIStoreController@show')->name('store.show');
    Route::post('store/delete', 'APIStoreController@delete')->name('store.delete');
});
?>