<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('scope', ['universitas', 'fakultas']);
            $table->string('faculty')->nullable();
            $table->integer('capacity');
            $table->text('facilities')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['scope', 'faculty']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
