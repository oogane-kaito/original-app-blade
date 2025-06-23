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
        Schema::create('business_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('theme')->default('nature');
            $table->string('backgroundColor')->default('#f0fdf4');
            $table->string('textColor')->default('#1f2937');
            $table->string('accentColor')->default('#22c55e');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('links')->nullable();
            $table->boolean('visibility')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_cards');
    }
};
