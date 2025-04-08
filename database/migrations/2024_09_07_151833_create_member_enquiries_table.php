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
        Schema::create('member_enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->index();
            $table->string('name',200)->nullable();
            $table->string('email',200)->nullable();
            $table->string('phone',20)->nullable();
            $table->enum('gender', ['male', 'female','other'])->default('male');
            $table->date('next_follow_up_date')->nullable();
            $table->text('location')->nullable();
            $table->text('interest')->nullable();
            $table->text('notes')->nullable();
            $table->string('enquiry_source',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_enquiries');
    }
};
