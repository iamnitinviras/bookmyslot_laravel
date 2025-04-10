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
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid('plan_id')->primary();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->string('name', 150);
            $table->double('price')->default(0);
            $table->integer('number_of_months')->default(12);
            $table->json('lang_name')->nullable();
            $table->longText('description')->nullable();
            $table->json('lang_description')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
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
