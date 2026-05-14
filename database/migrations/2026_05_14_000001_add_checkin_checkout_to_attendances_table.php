<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah kolom check_in, check_out, dan notes jika belum ada
            if (!Schema::hasColumn('attendances', 'check_in')) {
                $table->time('check_in')->nullable()->after('status');
            }
            if (!Schema::hasColumn('attendances', 'check_out')) {
                $table->time('check_out')->nullable()->after('check_in');
            }
            if (!Schema::hasColumn('attendances', 'notes')) {
                $table->string('notes')->nullable()->after('check_out');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumnIfExists('check_in');
            $table->dropColumnIfExists('check_out');
            $table->dropColumnIfExists('notes');
        });
    }
};
