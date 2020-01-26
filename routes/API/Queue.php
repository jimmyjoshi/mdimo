<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::any('queue', 'APIQueueController@index')->name('queue.index');
    Route::post('queue/create', 'APIQueueController@create')->name('queue.create');
    Route::post('queue/edit', 'APIQueueController@edit')->name('queue.edit');
    Route::post('queue/show', 'APIQueueController@show')->name('queue.show');
    Route::post('queue/delete', 'APIQueueController@delete')->name('queue.delete');
    Route::post('queue/remove-member', 'APIQueueController@removeMember')->name('queue.remove-member');
    Route::post('queue/process-member', 'APIQueueController@processMember')->name('queue.process-member');
});
?>