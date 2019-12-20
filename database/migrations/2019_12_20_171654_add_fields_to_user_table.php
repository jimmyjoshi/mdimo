<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->after('status')->default(0);
            $table->string('gender')->after('user_type')->nullable();
            $table->string('phone')->after('gender')->nullable();
            $table->string('profile_pic')->default('default.png')->nullable()->after('phone');
            $table->integer('age')->after('profile_pic');
            $table->date('birthdate')->nullable()->after('age');
            $table->text('notes')->nullable()->after('birthdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
