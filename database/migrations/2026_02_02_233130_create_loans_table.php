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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->decimal('loan_amount', 12, 2);
            $table->decimal('interest_amount', 12, 2);
            $table->enum('cycle', ['daily', 'weekly', 'monthly']);
            $table->decimal('paying_amount', 12, 2);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
