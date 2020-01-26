<?php

Route::group([
    "namespace"  => "Queue",
], function () {
    /*
     * Admin Queue Controller
     */

    // Route for Ajax DataTable
    Route::get("queue/get", "AdminQueueController@getTableData")->name("queue.get-list-data");

    Route::resource("queue", "AdminQueueController");
});