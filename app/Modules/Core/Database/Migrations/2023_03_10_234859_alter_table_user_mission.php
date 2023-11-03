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
            $table->unsignedBigInteger('info_mission_id')->after('user_id');
            $table->float('percent_complete')->default(0)->after('status');
            $table->longText('guilde_report_description')->nullable()->after('method_approval_type');
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
            $table->dropColumn('info_mission_id');
            $table->dropColumn('percent_complete');
            $table->longText('guilde_report_description');
        });
    }
};
