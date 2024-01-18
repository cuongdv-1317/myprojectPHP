<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username');
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender');
            $table->date('dob');
            $table->string('address')->nullable();
            $table->string('workplace')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_online')->default(true);
            $table->datetime('online_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('avatar');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('address');
            $table->dropColumn('workplace');
            $table->dropColumn('is_active');
            $table->dropColumn('is_online');
            $table->dropColumn('online_at');
        });
    }
}
