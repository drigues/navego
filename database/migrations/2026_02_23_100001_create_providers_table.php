<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('plan', 20)->default('basic'); // basic, pro
            $table->string('status', 20)->default('pending'); // pending, active, rejected
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('quotes_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
