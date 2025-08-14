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
            // Fix the typo in column name
            $table->renameColumn('payedBolean', 'is_paid');
        });

        Schema::table('tickets', function (Blueprint $table) {
            // Change the column type to boolean
            $table->boolean('is_paid')->default(false)->change();
        });

        Schema::table('events', function (Blueprint $table) {
            // Change price to decimal for proper currency handling
            $table->decimal('price', 10, 2)->change();

            // Add indexes for better performance
            $table->index('date_start');
            $table->index('date_end');
            $table->index(['date_start', 'date_end']);
            $table->index('location');
        });

        Schema::table('tickets', function (Blueprint $table) {
            // Change price to decimal
            $table->decimal('price', 10, 2)->change();

            // Add indexes
            $table->index('is_paid');
            $table->index('ticket_type');
            $table->index(['user_id', 'is_paid']);
            $table->index(['event_id', 'is_paid']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Add indexes for better performance
            $table->index('role');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->renameColumn('is_paid', 'payedBolean');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->string('is_paid')->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->integer('price')->change();
            $table->dropIndex(['date_start']);
            $table->dropIndex(['date_end']);
            $table->dropIndex(['date_start', 'date_end']);
            $table->dropIndex(['location']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('price')->change();
            $table->dropIndex(['is_paid']);
            $table->dropIndex(['ticket_type']);
            $table->dropIndex(['user_id', 'is_paid']);
            $table->dropIndex(['event_id', 'is_paid']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['email']);
        });
    }
};
