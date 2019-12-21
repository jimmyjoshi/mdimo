<?php

Route::group([
    "namespace"  => "Items",
], function () {
    /*
     * Admin Items Controller
     */

    // Route for Ajax DataTable
    Route::get("items/get", "AdminItemsController@getTableData")->name("items.get-list-data");

    Route::resource("items", "AdminItemsController");
});