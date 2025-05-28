<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 150);
            $table->string('slug', 150)->unique();
            $table->string('category_icon', 150)->default('fas fa-list');
            $table->json('lang_category_name')->nullable();
            $table->longText('description')->nullable();
            $table->json('lang_description')->nullable();
            $table->string('category_image', 150)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->unsignedBigInteger('sort_order')->default(1);
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
        Schema::dropIfExists('categories');
    }
};
