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
        Schema::table('tickets', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->nullable()->after('price');
            $table->string('payment_method')->nullable()->after('is_paid');
            $table->string('stripe_session_id')->nullable()->after('payment_method');
            $table->timestamp('purchased_at')->nullable()->after('stripe_session_id');

            $table->index('stripe_session_id');
            $table->index('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['stripe_session_id']);
            $table->dropIndex(['payment_method']);
            $table->dropColumn(['total_amount', 'payment_method', 'stripe_session_id', 'purchased_at']);
        });
    }
};
