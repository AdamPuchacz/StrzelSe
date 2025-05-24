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
        Schema::create('verification_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_request_id')->constrained()->onDelete('cascade');
            $table->string('path'); // Przechowywanie ścieżki pliku
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_files');
    }
};
