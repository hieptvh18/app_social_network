<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_user_missions', function (Blueprint $table) {
            $table->timestamp('finished_time')->nullable()->after('reward_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_user_missions', function (Blueprint $table) {
            $table->dropColumn('finished_time');
        });
    }
};
