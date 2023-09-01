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
        Schema::create('proposal_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained()->cascadeOnDelete();
            $table->enum('type', ['skripsi', 'teknologi_tepat_guna', 'jurnal'])->nullable();
            // transkrip nilai, krs 
            $table->string("requirement_pdf")->nullable();
            $table->date("date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_processes');
    }
};
