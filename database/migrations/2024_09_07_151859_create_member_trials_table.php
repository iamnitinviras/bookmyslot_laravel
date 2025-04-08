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
        Schema::create('member_trials', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('branch_id')->index();
            $table->string('name',200)->nullable();
            $table->string('phone_number',20)->nullable();
            $table->unsignedBigInteger('trainer')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('duration_of_trial')->default(3);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_trials');
    }
};
