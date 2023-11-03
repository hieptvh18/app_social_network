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
        Schema::table('core_blog_categories', function (Blueprint $table) {
            $table->index('is_show_homepage');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_blog_categories', function (Blueprint $table) {
            $table->dropIndex('is_show_homepage');
            $table->dropIndex('is_active');
        });
    }
};
