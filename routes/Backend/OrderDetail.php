<?php

Route::group([
    "namespace"  => "OrderDetail",
], function () {
    /*
     * Admin OrderDetail Controller
     */

    // Route for Ajax DataTable
    Route::get("orderdetail/get", "AdminOrderDetailController@getTableData")->name("orderdetail.get-list-data");

    Route::resource("orderdetail", "AdminOrderDetailController");
});