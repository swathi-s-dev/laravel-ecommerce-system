<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'order_date')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->date('order_date')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'order_date')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('order_date');
            });
        }
    }
};