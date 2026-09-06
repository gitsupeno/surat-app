<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('outgoing_letters')->where('status', 'approval')->update(['status' => 'menunggu_verifikasi']);
        DB::table('outgoing_letters')->where('status', 'terkirim')->update(['status' => 'sudah_dikirim']);
    }

    public function down(): void
    {
        DB::table('outgoing_letters')->where('status', 'menunggu_verifikasi')->update(['status' => 'approval']);
        DB::table('outgoing_letters')->where('status', 'sudah_dikirim')->update(['status' => 'terkirim']);
    }
};
