<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('practicum_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practicum_registration_id')->constrained('practicum_registrations')->cascadeOnDelete();
            $table->string('title');
            $table->string('report_file')->nullable();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->string('grade')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practicum_reports');
    }
};
