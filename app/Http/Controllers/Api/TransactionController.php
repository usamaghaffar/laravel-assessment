<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use Illuminate\Http\Request;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $transactions = $this->transactionRepository->getAllTransactions();

        return response()->json(['status' => 200,'transactions' => $transactions]);
    }

    public function store(TransactionStoreRequest $request)
    {
        $this->authorize('isAdmin', Auth::user());
        $transaction = $this->transactionRepository->storeTransaction($request->all());

        return response()->json(['status' => 201,'transaction' => $transaction]);
    }

    public function generateReport(Request $request) 
    {
        $this->authorize('isAdmin', Auth::user());
        $transactionsReport = $this->transactionRepository->generateTransactionsReport($request->all());
        
        return response()->json([
            'status' => 200,
            'transactionsReport' => $transactionsReport
        ]);
    }
}
