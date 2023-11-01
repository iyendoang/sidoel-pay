<?php
namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    public function deleted(Transaction $transaction)
    {
        // Hapus semua TransactionDetail terkait saat Transaction dihapus
        $transaction->transactionDetails()->delete();
    }
}
