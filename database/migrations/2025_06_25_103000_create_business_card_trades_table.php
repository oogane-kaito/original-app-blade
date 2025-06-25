<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
   {
       Schema::create('business_card_trades', function (Blueprint $table) {
           $table->id();
           $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
           $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
           $table->foreignId('card_id')->constrained('business_cards')->onDelete('cascade');
           $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
           $table->timestamps();
       });
   }

   public function down(): void
   {
       Schema::dropIfExists('business_card_trades');
   }
};