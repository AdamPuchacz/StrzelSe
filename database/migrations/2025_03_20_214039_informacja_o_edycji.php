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
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->boolean('is_edited')->default(false);
            $table->string('deleted_by')->nullable();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('is_edited')->default(false);
            $table->string('deleted_by')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
