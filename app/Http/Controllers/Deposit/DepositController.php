<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Transaction::query()
            ->where('user_id', auth()->id())
            ->where('transaction_type', 'deposit')
            ->latest()
            ->paginate(10);

        return view('deposit.index', compact('deposits'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Retrieve user by ID
        $user = auth()->user();

        // Update user's balance by adding the deposited amount
        $user->balance += $request->amount;
        $user->save();

        // Create a transaction record
        Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $request->amount,
            'fee' => 0, // Assuming no fee for deposits
            'date' => now(),
        ]);


        // Flash success message to session
        session()->flash('success', 'Amount deposited successfully');

        // Redirect back to the previous page with success message
        return redirect()->back();
    }
}
