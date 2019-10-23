<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAndAddAreaIdUserIdFromUsersAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_areas', function (Blueprint $table) {
            $table->dropForeign(['area_id']);

            $table->foreign('area_id')
                ->references('id')->on('areas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_areas', function (Blueprint $table) {
            $table->dropForeign(['area_id']);

            $table->foreign('area_id')
                ->references('id')->on('areas');
        });
    }
}
