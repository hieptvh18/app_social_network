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
        Schema::create('core_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('alias');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_thumbnail');
            $table->string('image_cover');
            $table->enum('type', ['STATIC', 'NORMAL'])->default('NORMAL');
            $table->dateTime('published_at');
            $table->dateTime('finished_at');
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'ARCHIVE'])->default('DRAFT');
            $table->enum('show_type', ['WEB', 'MOBILE'])->default('WEB');
            $table->enum('action_click_type', ['NORMAL', 'OPEN_BLANK'])->default('NORMAL');
            $table->boolean('is_featured')->default(false);
            $table->enum('bizapp', ['EDUQUIZ', 'CRM'])->default('CRM');
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_url')->nullable();
            $table->string('meta_keyword')->nullable();
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
        Schema::dropIfExists('core_blogs');
    }
};
