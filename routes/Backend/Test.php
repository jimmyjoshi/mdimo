<?php

Route::group([
    "namespace"  => "Test",
], function () {
    /*
     * Admin Test Controller
     */

    // Route for Ajax DataTable
    Route::get("test/get", "AdminTestController@getTableData")->name("test.get-list-data");

    Route::resource("test", "AdminTestController");
});