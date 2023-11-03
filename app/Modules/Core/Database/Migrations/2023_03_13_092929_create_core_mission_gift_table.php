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
        Schema::create('core_mission_gift', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('thumbnail_url')->nullable();
            $table->enum('type',['PLAN_VIP', 'MOBILE_CARD'])->default('PLAN_VIP');
            $table->bigInteger('exchange_point')->default(0);
            $table->boolean('allow_exchange_many')->default(false);
            $table->bigInteger('exchange_qty')->default(1);
            $table->timestamp('apply_start_date');
            $table->timestamp('apply_end_date');
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
        Schema::dropIfExists('core_mission_gift');
    }
};
