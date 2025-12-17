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
        Schema::table('transactions', function (Blueprint $table) {
            // Change enum to string to allow more values like 'project_purchase'
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Revert back to enum if needed (might fail if incompatible data exists)
            // For SQLite, we might just leave it as string or try to revert
            // $table->enum('type', ['listing_fee', 'featured_upgrade'])->change();
        });
    }
};
