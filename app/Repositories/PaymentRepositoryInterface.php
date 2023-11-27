<?php

namespace App\Repositories;

interface PaymentRepositoryInterface
{
    public function getAllPayments();
    
    public function storePayment($data);

    // Define other methods for user-related operations
}
