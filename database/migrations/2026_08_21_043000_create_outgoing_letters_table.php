<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('serial_no');
            $table->string('letter_number')->nullable()->unique();
            $table->date('date_letter')->nullable()->index();
            $table->string('recipient');
            $table->string('subject');
            $table->longText('body')->nullable();
            $table->foreignId('classification_id')->nullable()->constrained('letter_classifications')->nullOnDelete();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['draft', 'approval', 'terkirim'])->default('draft')->index();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['unit_id', 'serial_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};
