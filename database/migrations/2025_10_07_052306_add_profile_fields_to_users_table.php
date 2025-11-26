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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profession')->after('email'); // wajib diisi
            $table->string('photo_profile')->nullable()->after('profession'); // opsional
            $table->text('bio')->nullable()->after('photo_profile'); // opsional
        });
    }

public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profession', 'photo_profile', 'bio']);
        });
    }

};
