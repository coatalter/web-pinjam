<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('test_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('request_code')->unique();
            $table->enum('sample_type', ['tanah', 'air', 'jaringan_tanaman']);
            $table->text('sample_description')->nullable();
            $table->integer('num_samples')->default(1);
            $table->json('parameters')->nullable(); // JSON array of requested parameter IDs
            $table->enum('status', [
                'pending_payment',
                'payment_uploaded',
                'payment_verified',
                'in_testing',
                'in_review',
                'report_approved',
                'completed',
            ])->default('pending_payment');
            $table->text('notes')->nullable();

            // Payment
            $table->string('payment_proof')->nullable();
            $table->timestamp('payment_verified_at')->nullable();
            $table->foreignId('payment_verified_by')->nullable()->constrained('users')->nullOnDelete();

            // Assignment
            $table->foreignId('assigned_tester_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_reviewer_id')->nullable()->constrained('users')->nullOnDelete();

            // Report
            $table->string('report_file')->nullable();
            $table->foreignId('report_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('report_approved_at')->nullable();
            $table->timestamp('report_sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_requests');
    }
};
