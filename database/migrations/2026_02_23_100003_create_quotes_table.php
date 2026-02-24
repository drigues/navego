<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->text('description');
            $table->string('budget_range', 100)->nullable();
            $table->string('deadline', 100)->nullable();
            $table->string('status', 20)->default('new'); // new, viewed, replied, closed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
