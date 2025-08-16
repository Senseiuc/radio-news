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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // For admin reference
            $table->string('slot_id'); // Google AdSense slot ID
            $table->enum('type', ['banner', 'in-article', 'auto', 'custom'])->default('banner');
            $table->string('placement')->nullable(); // e.g., header, sidebar, footer
            $table->boolean('is_active')->default(true);
            $table->json('custom_code')->nullable(); // For raw HTML/JS ads
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
