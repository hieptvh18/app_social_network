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
        Schema::table('core_history_gift', function (Blueprint $table) {
            $table->unsignedBigInteger('gift_id')->nullable()->change();
            $table->enum('mission_type', ['EXAM', 'PROMOTION'])->default('EXAM')->after('gift_result');
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
