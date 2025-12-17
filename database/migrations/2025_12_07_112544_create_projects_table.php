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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('domain')->nullable();
            $table->integer('asking_price')->default(0); // in cents
            $table->enum('category', ['saas', 'ecommerce', 'content', 'tool', 'game', 'other']);
            $table->text('story'); // why it failed
            $table->string('tech_stack')->nullable();
            $table->integer('monthly_traffic')->nullable();
            $table->integer('total_revenue')->nullable(); // in cents
            $table->enum('status', ['pending', 'active', 'sold', 'expired'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->json('images')->nullable(); // array of image paths
            $table->string('contact_email');
            $table->integer('views')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('category');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
