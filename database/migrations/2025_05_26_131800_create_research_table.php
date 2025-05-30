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
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->integer('hospital_id');
            $table->enum('research_type', ['laboratoryjne', 'radiologiczne','zabieg'])->nullable();
            $table->string('note');
            $table->date('date_of_research');
            $table->enum('status', ['done', 'ongoing','canceled'])->nullable();
            $table->string('result');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
