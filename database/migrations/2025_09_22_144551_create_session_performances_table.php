<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->date('session_date');
            $table->unsignedTinyInteger('score')->comment('Performance score for the session (0-100)');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_performances');
    }
};
