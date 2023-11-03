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
        Schema::table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->index(['ip_address', 'user_agent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropIndex(['ip_address', 'user_agent']);
        });
    }
};