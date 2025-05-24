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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nazwa zawodów
            $table->text('description'); // Opis zawodów
            $table->date('date'); // Data zawodów
            $table->string('location'); // Lokalizacja
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Użytkownik, który dodał zawody
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
