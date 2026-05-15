<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Ubah kolom status agar mendukung nilai 'telat'
            $table->string('status')->default('hadir')->change();
        });
    }

    public function down(): void
    {
        //
    }
};
