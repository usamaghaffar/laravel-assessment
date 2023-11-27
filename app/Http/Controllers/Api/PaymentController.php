<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStoreRequest;
use App\Models\Transaction;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $paymentRepository;
 
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function index()
    {
        $this->authorize('isAdmin', Auth::user());
        $payments = $this->paymentRepository->getAllPayments();

        return response()->json(['status' => 200,'payments' => $payments]);
    }

    public function store(PaymentStoreRequest $request)
    {
        $this->authorize('isAdmin', Auth::user());
        $payment = $this->paymentRepository->storePayment($request->all());

        if ($payment) {
            $transaction = Transaction::find($payment->transaction_id);
            if ($payment->amount >= $transaction->amount) {
                $transaction->status = 'paid';
                $transaction->save();
            }
        }

        return response()->json(['status' => 201,'payment' => $payment]);
    }
}
