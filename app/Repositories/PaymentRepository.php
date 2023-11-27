<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAllPayments()
    {
        return Payment::paginate(12);
    }
    public function storePayment($data)
    {
        return Payment::create([
            'transaction_id' => $data['transaction_id'],
            'amount' => $data['amount'],
            'paid_on' => $data['paid_on'],
            'details' => $data['details'],
        ]);
    }
}
