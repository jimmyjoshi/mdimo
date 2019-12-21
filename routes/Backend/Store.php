<?php

Route::group([
    "namespace"  => "Store",
], function () {
    /*
     * Admin Store Controller
     */

    // Route for Ajax DataTable
    Route::get("store/get", "AdminStoreController@getTableData")->name("store.get-list-data");

    Route::resource("store", "AdminStoreController");
});