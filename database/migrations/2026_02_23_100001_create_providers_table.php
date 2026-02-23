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
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('nif', 20)->nullable(); // Número de Identificação Fiscal
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('contact_email')->nullable();
            $table->json('languages')->nullable(); // languages spoken: ["pt","en","es"]
            $table->json('social_links')->nullable(); // {"facebook":"...","instagram":"..."}
            $table->json('working_hours')->nullable(); // {"mon":"9-18","tue":"9-18",...}
            $table->boolean('serves_remote')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
