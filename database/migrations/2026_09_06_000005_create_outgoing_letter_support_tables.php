<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outgoing_letter_number_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_code')->default('SEKOLAH');
            $table->string('format')->default('{nomor}/{kode_sekolah}/{bulan_romawi}/{tahun}');
            $table->boolean('reset_yearly')->default(true);
            $table->unsignedInteger('next_number')->default(1);
            $table->timestamps();
        });

        Schema::create('outgoing_letter_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->nullable()->constrained('jenis_surat')->nullOnDelete();
            $table->string('name');
            $table->longText('content');
            $table->boolean('use_letterhead')->default(true);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id');
            $table->string('action');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamps();
            $table->index(['auditable_type', 'auditable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('outgoing_letter_templates');
        Schema::dropIfExists('outgoing_letter_number_settings');
    }
};
