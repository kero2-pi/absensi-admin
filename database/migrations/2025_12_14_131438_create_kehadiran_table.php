<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('shift');
            $table->time('jam_shift_masuk');
            $table->time('jam_masuk')->nullable();
            $table->string('mode_kerja')->nullable();
            $table->date('tanggal');
            $table->enum('status', ['ALPA', 'HADIR', 'IZIN', 'CUTI', 'SAKIT' ])->default('ALPA');
            $table->boolean('terlambat')->default(false);
            $table->string('keterlambatan')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
