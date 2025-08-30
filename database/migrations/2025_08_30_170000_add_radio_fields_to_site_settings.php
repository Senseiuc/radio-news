<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('radio_stream_url')->nullable()->after('contact_email');
            $table->string('radio_now_playing')->nullable()->after('radio_stream_url');
            $table->json('radio_schedule')->nullable()->after('radio_now_playing');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['radio_stream_url','radio_now_playing','radio_schedule']);
        });
    }
};
