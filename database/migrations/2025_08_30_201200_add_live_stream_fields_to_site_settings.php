<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('youtube_live_url')->nullable()->after('youtube_url');
            $table->string('facebook_live_url')->nullable()->after('youtube_live_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['youtube_live_url','facebook_live_url']);
        });
    }
};
