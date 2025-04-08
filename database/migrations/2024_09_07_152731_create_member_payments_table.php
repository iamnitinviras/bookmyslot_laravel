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
        Schema::create('member_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('member_pk_id')->nullable()->index();
            $table->unsignedBigInteger('package_id')->nullable()->index();
            $table->double('amount_paid')->default(0);
            $table->double('package_price')->default(0);
            $table->double('discount')->default(0);
            $table->date('payment_date')->nullable();
            $table->date('bill_date')->nullable();
            $table->date('activation_date')->nullable();
            $table->enum('payment_type',['full','partial'])->default('full');
            $table->double('due_amount')->default(0);
            $table->string('payment_mode',100)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_payments');
    }
};
