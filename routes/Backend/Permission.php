<?php

Route::group([
    "namespace"  => "Permission",
], function () {
    /*
     * Admin Permission Controller
     */

    // Route for Ajax DataTable
    Route::get("permission/get", "AdminPermissionController@getTableData")->name("permission.get-list-data");

    Route::resource("access/permission", "AdminPermissionController");
});