<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->unique()->after('id');
            $table->decimal('tax_rate', 5, 2)->nullable()->default(0)->after('amount');
            $table->string('payment_terms')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'tax_rate', 'payment_terms']);
        });
    }
};
