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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title',200)->nullable();
            $table->string('slug',150)->unique();
            $table->unsignedBigInteger('category_id')->index();
            $table->longText('description')->nullable();
            $table->json('lang_title')->nullable();
            $table->json('lang_description')->nullable();
            $table->longText('image')->nullable();
            $table->longText('tags')->nullable();
            $table->enum('status',['published','unpublished'])->default('published');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->longText('seo_keyword')->nullable();
            $table->longText('seo_description')->nullable();
            $table->unsignedBigInteger('total_views')->default(0);
            $table->boolean('display_in_slider')->default(false);
            $table->boolean('display_in_top_of_week')->default(false);
            $table->unsignedBigInteger('read_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
