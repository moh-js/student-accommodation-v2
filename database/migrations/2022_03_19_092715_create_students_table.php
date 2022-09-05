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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->comment('registration_# or form_4_index_#');
            $table->enum('award', [
                'certificate', 'diploma', 'bachelor', 'master', 'PhD', 'postgraduate diploma'
            ])->nullable();
            $table->string('department')->nullable();
            $table->string('programme')->nullable();
            $table->string('level')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->date('dob')->nullable();
            $table->foreignId('gender_id')->constrained()->cascadeOnDelete();
            $table->enum('student_type', [
                'fresher', 'continuous', 'foreigner', 'disabled'
            ]);
            $table->enum('sponsor', [
                'private', 'government', 'heslb'
            ])->nullable();
            $table->boolean('is_fresher')->default(1);
            $table->boolean('verified')->default(0);
            $table->boolean('edit')->default(0);
            $table->string('secret')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('students');
    }
};
