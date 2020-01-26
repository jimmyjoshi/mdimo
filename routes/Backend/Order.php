<?php

Route::group([
    "namespace"  => "Order",
], function () {
    /*
     * Admin Order Controller
     */

    // Route for Ajax DataTable
    Route::get("order/get", "AdminOrderController@getTableData")->name("order.get-list-data");

    Route::resource("order", "AdminOrderController");
});