<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->integer('amount'); // Offer amount in cents
            $table->text('note')->nullable(); // Optional message with offer
            $table->enum('status', ['pending', 'accepted', 'rejected', 'countered'])->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            $table->index(['project_id', 'status']);
            $table->index('buyer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
