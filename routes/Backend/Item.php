<?php

Route::group([
    "namespace"  => "Item",
], function () {
    /*
     * Admin Item Controller
     */

    // Route for Ajax DataTable
    Route::get("item/get", "AdminItemController@getTableData")->name("item.get-list-data");

    Route::resource("item", "AdminItemController");
});