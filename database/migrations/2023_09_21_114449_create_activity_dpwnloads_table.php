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
        Schema::create('activity_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('file')->cascadeOnDelete();
            $table->string('ip_address');
            $table->string('code');
            $table->string('country')->nullable();
            $table->string('user_agent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_downloads');
    }
};
