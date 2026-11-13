<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('username', 'ismaele.t')->update(['mail' => 'ismaele.tuffanelli@gmail.com']);
        DB::table('users')->where('username', 'Bottega')->update(['mail' => 'silvia@bottegadelleerbe.com']);
    }

    public function down(): void
    {
        // Previous email addresses are unknown and cannot be restored.
    }
};
