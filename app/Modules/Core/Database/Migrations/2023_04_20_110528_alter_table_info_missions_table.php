<?php

use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE core_info_missions MODIFY assign_user_type ENUM('AUTO', 'MANUAL', 'PROMOTION') DEFAULT 'AUTO'");
        DB::statement("ALTER TABLE core_info_missions MODIFY apply_entity_type ENUM('EXAM', 'DOCUMENT', 'USER') DEFAULT 'EXAM'");
        Schema::table('core_info_missions', function (Blueprint $table) {
            $table->enum('reward_type', ['REWARD_POINT','GIFT'])->default('REWARD_POINT')->after('expired_time_after');
            $table->string('banner_url')->nullable()->after('reward_type');
            $table->string('image_url')->nullable()->after('banner_url');
            $table->unsignedBigInteger('gift_id')->nullable()->after('image_url');
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
