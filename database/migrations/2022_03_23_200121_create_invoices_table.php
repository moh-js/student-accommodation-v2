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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_no')->unique()->nullable();
            $table->string('reference')->unique();
            $table->integer('control_number')->nullable();
            $table->string('receipt')->nullable();
            $table->string('bank_receipt')->nullable();
            $table->string('gateway_receipt')->nullable();
            $table->integer('amount_paid')->nullable();
            $table->integer('amount')->nullable();
            $table->string('trans_date')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('currency')->nullable();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->boolean('status')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
