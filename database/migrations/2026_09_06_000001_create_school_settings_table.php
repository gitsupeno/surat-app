<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('government_name');
            $table->string('department_name');
            $table->string('branch_department_name')->nullable();
            $table->string('school_name');
            $table->text('address');
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('province_logo_path')->nullable();
            $table->string('school_logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
