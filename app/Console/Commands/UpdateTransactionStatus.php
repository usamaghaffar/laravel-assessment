<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Console\Command;

class UpdateTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-transaction-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transactions = Transaction::where('status', '!=' , 'paid')->get();
        foreach ($transactions as $key => $transaction) {
            $transactionPaymentAmount = Payment::where('transaction_id', $transaction->id)->sum('amount');
            if ($transaction->amount <= $transactionPaymentAmount && $transaction->due_on >= now()->format('Y-m-d')) {
                $transaction->update(['status' => 'paid']);
            }elseif($transaction->amount > $transactionPaymentAmount && $transaction->due_on > now()->format('Y-m-d')){
                $transaction->update(['status' => 'outstanding']);
            }elseif($transaction->amount > $transactionPaymentAmount  && $transaction->due_on <= now()->format('Y-m-d')){
                $transaction->update(['status' => 'overdue']);
            }
        }
        $this->info('Transactions status updated successfully.');
    }
}
