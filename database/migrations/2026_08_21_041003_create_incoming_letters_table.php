<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->string('mail_number')->nullable()->index();
            $table->date('date_letter')->nullable()->index();
            $table->date('date_received')->nullable();
            $table->string('sender')->nullable();
            $table->string('subject');
            $table->foreignId('sifat_id')->nullable()->constrained('jenis_surat')->nullOnDelete();
            $table->foreignId('classification_id')->nullable()->constrained('letter_classifications')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->enum('status', ['baru', 'didisposisikan', 'selesai'])->default('baru')->index();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
    }
};
