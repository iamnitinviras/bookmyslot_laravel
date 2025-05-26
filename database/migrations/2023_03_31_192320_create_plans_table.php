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
        Schema::create('plans', function (Blueprint $table)
        {
            $table->uuid('plan_id')->primary();
            $table->string('title', 190);
            $table->longText('description')->nullable();
            $table->longText('lang_plan_title')->nullable();
            $table->longText('lang_plan_description')->nullable();
            $table->double('amount')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('type', ['onetime', 'monthly', 'weekly', 'yearly', 'trial', 'free', 'day']);
            $table->integer('branch_limit')->default(0);
            $table->enum('unlimited_branch', ['yes', 'no'])->default('no');

            $table->integer('member_limit')->default(0);
            $table->enum('unlimited_member', ['yes', 'no'])->default('no');

            $table->integer('staff_limit')->default(0);
            $table->enum('staff_unlimited', ['yes', 'no'])->default('no');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->string('stripe_plan_id', 100)->nullable();
            $table->string('paypal_plan_id', 100)->nullable();
            $table->string('razorpay_plan_id', 100)->nullable();
            $table->string('paystack_plan_id', 100)->nullable();
            $table->string('midtrans_plan_id', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
