<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDataQueueMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_data_queue_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('queue_id');
            $table->integer('store_id');
            $table->integer('user_id');
            $table->integer('queue_number')->default(1);
            $table->integer('member_count')->default(1);
            $table->integer('processed_number')->default(null)->nullable();
            $table->datetime('processed_at')->default(null)->nullable();
            $table->text('description')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_data_queue_members');
    }
}
