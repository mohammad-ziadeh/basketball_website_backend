<?php

// database/migrations/2025_10_16_000001_create_billings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->decimal('total_income', 10, 2)->default(0); // sum of paid payments
            $table->decimal('total_expenses', 10, 2)->default(0); // sum of expenses
            $table->decimal('final_payment', 10, 2)->default(0); // total_income - total_expenses
            $table->integer('month'); // 1-12
            $table->integer('year'); // 2025
            $table->timestamps();
            $table->unique(['course_id', 'month', 'year']);
        });

        Schema::create('billing_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->constrained('billings')->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_expenses');
        Schema::dropIfExists('billings');
    }
};
