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
        Schema::create('transactions', function (Blueprint $table)
        {
            $table->uuid('id')->primary();
            $table->enum('payment_method', ['stripe', 'paypal', 'razorpay', 'manually'])->default('manually');
            $table->string('transaction_id', 200)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->uuid('plan_id')->nullable();
            $table->uuid('subscription_id')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->longText('details')->nullable();
            $table->longText('payment_response')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
