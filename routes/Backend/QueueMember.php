<?php

Route::group([
    "namespace"  => "QueueMember",
], function () {
    /*
     * Admin QueueMember Controller
     */

    // Route for Ajax DataTable
    Route::get("queuemember/get", "AdminQueueMemberController@getTableData")->name("queuemember.get-list-data");

    Route::resource("queuemember", "AdminQueueMemberController");
});