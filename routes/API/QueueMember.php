<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('queuemember', 'APIQueueMemberController@index')->name('queuemember.index');
    Route::post('queuemember/create', 'APIQueueMemberController@create')->name('queuemember.create');
    Route::post('queuemember/edit', 'APIQueueMemberController@edit')->name('queuemember.edit');
    Route::post('queuemember/show', 'APIQueueMemberController@show')->name('queuemember.show');
    Route::post('queuemember/delete', 'APIQueueMemberController@delete')->name('queuemember.delete');
});
?>