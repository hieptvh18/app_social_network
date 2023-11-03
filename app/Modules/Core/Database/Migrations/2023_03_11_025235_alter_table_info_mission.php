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
            $table->timestamp('apply_start_date')->nullable()->after('is_active');
            $table->timestamp('apply_end_date')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_info_missions', function (Blueprint $table) {
            $table->dropColumn('apply_start_date');
            $table->dropColumn('apply_end_date');
        });
    }
};
