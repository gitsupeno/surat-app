<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disposition_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disposition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('responded_by')->constrained('users')->cascadeOnDelete();
            $table->text('response');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposition_responses');
    }
};
