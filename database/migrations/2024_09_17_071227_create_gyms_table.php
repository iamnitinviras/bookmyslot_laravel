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
        Schema::create('gyms', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('title', 190);
            $table->string('email', 190)->nullable();
            $table->string('address', 190)->nullable();
            $table->string('contact_person_name', 190)->nullable();
            $table->string('contact_person_phone', 20)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('website', 190)->nullable();
            $table->string('slug', 150)->unique()->nullable();
            $table->longText('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gyms');
    }
};
