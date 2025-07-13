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
        Schema::table('bug_reports', function (Blueprint $table) {
            // Menambahkan kolom reporter_id setelah kolom id
            $table->unsignedBigInteger('reporter_id')->after('id');

            // Menambahkan foreign key constraint ke tabel users
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bug_reports', function (Blueprint $table) {
            // Menghapus foreign key dan kolom reporter_id jika rollback migration
            $table->dropForeign(['reporter_id']);
            $table->dropColumn('reporter_id');
        });
    }
};
