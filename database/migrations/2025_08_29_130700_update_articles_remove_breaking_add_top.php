<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'is_breaking')) {
                $table->dropColumn('is_breaking');
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (! Schema::hasColumn('articles', 'is_top')) {
                $table->boolean('is_top')->default(false)->after('is_featured');
                $table->index('is_top');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'is_top')) {
                $table->dropIndex(['is_top']);
                $table->dropColumn('is_top');
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (! Schema::hasColumn('articles', 'is_breaking')) {
                $table->boolean('is_breaking')->default(false)->after('is_featured');
            }
        });
    }
};
