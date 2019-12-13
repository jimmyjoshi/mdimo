<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('permission', 'APIPermissionController@index')->name('permission.index');
    Route::post('permission/create', 'APIPermissionController@create')->name('permission.create');
    Route::post('permission/edit', 'APIPermissionController@edit')->name('permission.edit');
    Route::post('permission/show', 'APIPermissionController@show')->name('permission.show');
    Route::post('permission/delete', 'APIPermissionController@delete')->name('permission.delete');
});
?>