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
        Schema::create('core_info_missions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description');
            $table->enum('assign_user_type',['AUTO','MANUAL'])->default('AUTO');
            $table->enum('apply_entity_type',['EXAM','DOCUMENT'])->default('EXAM');
            $table->enum('method_reward_point_type',['SHARE','VIEWED','DOWNLOAD','TOTAL_CREATE'])->default('SHARE');
            $table->bigInteger('reward_point_condition_number')->default(0);
            $table->enum('method_approval_type',['AUTO','MANUAL'])->default('AUTO');
            $table->bigInteger('reward_point')->default(0);
            $table->enum('expired_time_type',['DAY','HOUR','MINUTE'])->default('DAY');
            $table->bigInteger('expired_time_after')->default(0);
            $table->boolean('is_active')->default(true);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_info_missions');
    }
};
