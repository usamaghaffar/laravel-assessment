<?php

namespace App\Repositories;

interface TransactionRepositoryInterface
{
    public function getAllTransactions();
    
    public function storeTransaction($data);

    public function generateTransactionsReport($data);

    // Define other methods for user-related operations
}
