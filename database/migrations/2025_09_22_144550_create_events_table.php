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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('venue')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', [
                'event-primary',
                'event-secondary',
                'event-success',
                'event-danger',
                'event-warning',
                'event-info'
            ])->default('event-primary');
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
