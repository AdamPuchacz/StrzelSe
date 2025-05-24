<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Zmiana kolumny 'role' z ENUM na VARCHAR
            $table->string('role', 50)->default('user')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Przywrócenie ENUM, jeśli trzeba cofnąć migrację
            $table->enum('role', ['user', 'admin', 'verified'])->default('user')->change();
        });
    }
};
