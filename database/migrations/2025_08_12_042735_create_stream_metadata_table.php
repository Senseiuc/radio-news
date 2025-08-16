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
        Schema::create('stream_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('current_song')->nullable(); // "Artist - Title" or show name
            $table->integer('listeners')->default(0);   // Current listeners
            $table->boolean('is_online')->default(false);
            $table->integer('peak_listeners')->default(0);
            $table->integer('bitrate')->nullable();     // kbps quality
            $table->timestamp('last_online_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stream_metadata');
    }
};
