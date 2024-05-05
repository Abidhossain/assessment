<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Retrieve all transactions for the logged-in user
        $transactions = Transaction::query()
            ->where('user_id', auth()->id())
            ->paginate(10);

        // Calculate current balance
        $currentBalance = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->transaction_type === 'deposit') {
                $currentBalance += $transaction->amount;
            } elseif ($transaction->transaction_type === 'withdraw') {
                $currentBalance -= $transaction->amount;
            }
            // Subtract any fees if applicable
            $currentBalance -= $transaction->fee;
        }

        return view('transaction.index', compact('transactions', 'currentBalance'));
    }

}
