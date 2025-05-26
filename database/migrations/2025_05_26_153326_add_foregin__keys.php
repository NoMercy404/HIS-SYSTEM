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
        Schema::table('hospitalisations', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });

        Schema::table('visits', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('research', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitalisations')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitalisations', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
        });

        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);
        });

        Schema::table('research', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
        });
    }

};
