<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW reports AS
            SELECT 
                YEAR(due_on) AS year,
                MONTH(due_on) AS month,
                SUM(amount) AS total_amount,
                SUM(
                    (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE transaction_id = transactions.id)
                ) AS paid,
                SUM(amount) - SUM(
                    (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE transaction_id = transactions.id)
                ) AS outstanding,
                COUNT(
                    CASE WHEN due_on < CURRENT_DATE AND status != 'paid' THEN id END
                ) AS overdue
            FROM transactions
            GROUP BY YEAR(due_on), MONTH(due_on);
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS reports');
    }
};
