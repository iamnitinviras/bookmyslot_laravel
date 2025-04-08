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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('gym_customer_id')->index();
            $table->string('name', 150);
            $table->string('email',190)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('join_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('package_start_date')->nullable();
            $table->date('package_end_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('package_id')->nullable()->index();
            $table->string('height', 10)->nullable();
            $table->string('weight', 10)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('zip', 10)->nullable();
            $table->text('profile_image')->nullable();
            $table->enum('gender', ['male', 'female','other'])->default('male');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('primary_goal', 150)->nullable();
            $table->string('secondary_goal', 150)->nullable();
            $table->string('occupation', 150)->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->text('notes')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
