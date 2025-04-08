<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id('plan_id');
            $table->string('title',190);
            $table->string('lang_plan_title',190)->nullable();
            $table->double('amount')->default(0);
            $table->enum('type',['onetime','monthly','weekly','yearly','trial','free','day']);
            $table->integer('branch_limit')->default(0);
            $table->enum('branch_unlimited',['yes','no'])->default('no');

            $table->integer('member_limit')->default(0);
            $table->enum('member_unlimited',['yes','no'])->default('no');

            $table->integer('staff_limit')->default(0);
            $table->enum('staff_unlimited',['yes','no'])->default('no');
            $table->enum('status',['active','inactive'])->default('active');

            $table->string('stripe_branch_id',150)->nullable();
            $table->string('paypal_branch_id',150)->nullable();
            $table->string('paypal_plan_id',150)->nullable();
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
