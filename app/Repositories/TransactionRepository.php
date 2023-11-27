<?php

namespace App\Repositories;

use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getAllTransactions()
    {
        $authUser = Auth::user();
        if ($authUser->role_id == 1) {
            return Transaction::paginate(12);
        }else{
            return Transaction::where('user_id', $authUser->id)->paginate(12);
        }
    }
    public function storeTransaction($data)
    {
        $currentDate = now()->format('Y-m-d');
        $data['status'] = 'outstanding';
        if ($currentDate == $data['due_on']) {
            $data['status'] = 'orverdue';
        }
        
        return Transaction::create([
            'amount' => $data['amount'],
            'user_id' => $data['user_id'],
            'due_on' => $data['due_on'],
            'vat' => $data['vat'],
            'is_vat_inclusive' => $data['is_vat_inclusive'],
            'status' => $data['status'],
        ]);
    }

    public function generateTransactionsReport($data) 
    {
       return Report::paginate(12);
    }
}
