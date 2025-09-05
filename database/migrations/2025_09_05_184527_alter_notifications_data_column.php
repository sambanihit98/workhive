<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Only run this for Postgres
        if (DB::getDriverName() === 'pgsql') {
            // Step 1: Drop old column
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropColumn('data');
            });

            // Step 2: Recreate as jsonb
            Schema::table('notifications', function (Blueprint $table) {
                $table->jsonb('data');
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropColumn('data');
                $table->text('data'); // revert back
            });
        }
    }
};
