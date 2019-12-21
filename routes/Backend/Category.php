<?php

Route::group([
    "namespace"  => "Category",
], function () {
    /*
     * Admin Category Controller
     */

    // Route for Ajax DataTable
    Route::get("category/get", "AdminCategoryController@getTableData")->name("category.get-list-data");

    Route::resource("category", "AdminCategoryController");
});