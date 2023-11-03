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
        Schema::table(config('core.tables.plans'), function (Blueprint $table) {
            $table->enum('user_type', ['TEACHER', 'STUDENT', 'COMPANY']);
            $table->enum('bizapp', ['EDUQUIZ', 'PORTFOLIO']);
            $table->json('customStyle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('core.tables.plans'), function (Blueprint $table) {
            $table->dropColumn('user_type', 'bizapp');
            $table->dropColumn('customStyle');
        });
    }
};
