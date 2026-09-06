<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->foreignId('jenis_surat_id')->nullable()->after('letter_number')->constrained('jenis_surat')->nullOnDelete();
            $table->string('sifat')->default('biasa')->after('subject');
            $table->string('lampiran')->nullable()->after('sifat');
            $table->string('recipient_position')->nullable()->after('recipient');
            $table->text('recipient_address')->nullable()->after('recipient_position');
            $table->string('recipient_email')->nullable()->after('recipient_address');
            $table->text('opening')->nullable()->after('body');
            $table->text('closing')->nullable()->after('opening');
            $table->string('signer_name')->nullable()->after('closing');
            $table->string('signer_nip')->nullable()->after('signer_name');
            $table->string('signer_position')->nullable()->after('signer_nip');
            $table->string('signature_path')->nullable()->after('signer_position');
            $table->boolean('use_letterhead')->default(true)->after('signature_path');
            $table->foreignId('verified_by')->nullable()->after('approved_by')->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable()->after('approved_at');
            $table->text('rejection_reason')->nullable()->after('verified_at');
            $table->timestamp('sent_at')->nullable()->after('rejection_reason');
            $table->timestamp('archived_at')->nullable()->after('sent_at');
        });

        DB::statement("ALTER TABLE outgoing_letters MODIFY status VARCHAR(40) NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropForeign(['jenis_surat_id']);
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'jenis_surat_id',
                'sifat',
                'lampiran',
                'recipient_position',
                'recipient_address',
                'recipient_email',
                'opening',
                'closing',
                'signer_name',
                'signer_nip',
                'signer_position',
                'signature_path',
                'use_letterhead',
                'verified_by',
                'verified_at',
                'rejection_reason',
                'sent_at',
                'archived_at',
            ]);
        });
    }
};
