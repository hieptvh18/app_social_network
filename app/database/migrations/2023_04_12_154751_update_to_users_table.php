<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio')->nullable()->comment('Introduce personal infomation');
            $table->string('username')->nullable(false)->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable()->default('https://pbs.twimg.com/media/EYVxlOSXsAExOpX.jpg')->comment('avatar image');
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('Public or private my profile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
