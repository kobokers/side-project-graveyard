<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            
            // Payment amounts (in cents)
            $table->integer('amount_paid'); // Full price paid by buyer
            $table->integer('seller_amount'); // Amount seller receives (after commission)
            $table->integer('commission_amount'); // Platform's 5% commission
            
            // Transaction status
            $table->enum('status', [
                'pending',      // Payment processing
                'escrowed',     // Payment held, awaiting transfer
                'in_transfer',  // Seller transferring assets
                'completed',    // Buyer confirmed, seller paid
                'disputed',     // Issue raised
                'refunded'      // Payment returned to buyer
            ])->default('pending');
            
            // Stripe IDs
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_transfer_id')->nullable(); // Transfer to seller
            
            // Transfer tracking
            $table->text('transfer_notes')->nullable(); // Seller's notes about transfer
            $table->json('transfer_files')->nullable(); // Uploaded proof files
            
            // Timestamps for workflow
            $table->timestamp('escrowed_at')->nullable();
            $table->timestamp('transfer_started_at')->nullable();
            $table->timestamp('buyer_confirmed_at')->nullable();
            $table->timestamp('seller_paid_at')->nullable();
            $table->timestamp('disputed_at')->nullable();
            $table->text('dispute_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('buyer_id');
            $table->index('seller_id');
            $table->index('status');
        });
        
        // Add columns to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('buyer_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            $table->timestamp('purchased_at')->nullable()->after('featured_until');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropColumn(['buyer_id', 'purchased_at']);
        });
        
        Schema::dropIfExists('purchases');
    }
};
