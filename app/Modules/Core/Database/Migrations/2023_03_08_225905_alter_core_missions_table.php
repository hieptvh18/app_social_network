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
        Schema::table('core_info_missions', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->bigInteger('expired_time_after')->default(0)->nullable()->change();
        });

        Schema::table('core_user_missions', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->bigInteger('expired_time_after')->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
