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
        Schema::create('package_renewals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_pk_id')->index();
            $table->unsignedBigInteger('previous_package_id')->index();
            $table->unsignedBigInteger('new_package_id')->index();
            $table->date('renewal_date')->nullable();
            $table->date('new_expiry_date')->nullable();
            $table->double('amount_paid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_renewals');
    }
};
