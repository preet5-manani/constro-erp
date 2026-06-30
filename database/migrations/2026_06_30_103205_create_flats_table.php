<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained()->cascadeOnDelete();
            $table->string('flat_number');
            $table->decimal('area', 10, 2)->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('status')->default('available'); // available|reserved|booked|sold
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
