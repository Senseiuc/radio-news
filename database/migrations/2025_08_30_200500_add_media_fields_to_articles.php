<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('audio_url')->nullable()->after('video_url');
            $table->string('audio_file_path')->nullable()->after('audio_url');
            $table->string('video_file_path')->nullable()->after('audio_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['audio_url', 'audio_file_path', 'video_file_path']);
        });
    }
};
