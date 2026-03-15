<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // 1. Hapus index unik yang lama (hanya nomor dokumen)
            // Nama index default biasanya: documents_document_number_unique
            $table->dropUnique(['document_number']);

            // 2. Buat index unik baru: Gabungan Nomor Dokumen DAN Versi
            // Jadi: Nomor sama boleh, asalkan versinya beda (1.0, 1.1, dst)
            $table->unique(['document_number', 'version']);
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropUnique(['document_number', 'version']);
            $table->unique('document_number');
        });
    }
};