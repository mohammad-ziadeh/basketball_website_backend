<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monthly_performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->constrained('users')->onDelete('cascade');
            $table->year('year');
            $table->tinyInteger('month');
            $table->float('average_score')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['player_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_performances');
    }
};
