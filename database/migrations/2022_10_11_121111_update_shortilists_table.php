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
        Schema::table('shortlists', function (Blueprint $table) {
            $table->date('payment_deadline_start')->nullable()->after('is_published');
            $table->boolean('is_banned')->default(0)->after('payment_deadline_start');
            $table->boolean('has_reg_number')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shortlists', function (Blueprint $table) {
            $table->dropColumn('payment_deadline_start');
            $table->dropColumn('is_banned');
            $table->dropColumn('has_reg_number');
        });
    }
};
