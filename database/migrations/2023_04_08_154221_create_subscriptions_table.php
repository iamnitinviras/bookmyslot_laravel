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
        Schema::create('subscriptions', function (Blueprint $table)
        {
            $table->uuid(column: 'id')->primary();
            $table->unsignedInteger('user_id');
            $table->uuid('plan_id');
            $table->string('payment_method')->nullable();
            $table->string('payment_type', 150)->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->enum('is_current', ['yes', 'no'])->default('no');

            $table->longText('details')->nullable();
            $table->longText('remark')->nullable();
            $table->double('amount')->default(0);
            $table->enum('type', ['onetime', 'monthly', 'weekly', 'yearly', 'trial', 'free', 'day']);

            $table->integer('member_limit')->default(0);
            $table->enum('unlimited_member', ['yes', 'no'])->default('no');

            $table->integer('branch_limit')->default(0);
            $table->enum('unlimited_branch', ['yes', 'no'])->default('no');

            $table->integer('staff_limit')->default(0);
            $table->enum('staff_unlimited', ['yes', 'no'])->default('no');

            $table->enum('status', ['pending', 'approved', 'rejected', 'canceled', 'expired'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->longText('subscription_id')->nullable();
            $table->longText('json_response')->nullable();
            $table->boolean('is_processed')->default(false);

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
        Schema::dropIfExists('subscriptions');
    }
};
