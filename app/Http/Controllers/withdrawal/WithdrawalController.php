<?php

namespace App\Http\Controllers\withdrawal;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdraws = Transaction::query()
            ->where('user_id', auth()->id())
            ->where('transaction_type', 'withdraw')
            ->latest()
            ->paginate(10);

        return view('withdraw.index', compact('withdraws'));
    }


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Retrieve user by ID
        $user = auth()->user();

        // Check the user's account type
        $accountType = $user->account_type;

        // Apply withdrawal fee based on account type
        $withdrawalFee = $this->calculateWithdrawalFee($user, $request->amount);

        // Update user's balance by deducting the withdrawn amount and fee
        $withdrawalAmount = $request->amount + $withdrawalFee;
        $user->balance -= $withdrawalAmount;
        $user->save();

        // Create a transaction record
        Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'withdraw',
            'amount' => $request->amount,
            'fee' => $withdrawalFee,
            'date' => now(),
        ]);

        // Return a success response
        session()->flash('success', 'Amount Withdrawal successfully');

        // Redirect back to the previous page with success message
        return redirect()->back();
    }

    // Method to calculate withdrawal fee based on account type and withdrawal amount
    private function calculateWithdrawalFee($user, $amount)
    {
        // Apply appropriate withdrawal rate based on account type
        $withdrawalRate = ($user->account_type === 'individual') ? 0.015 : 0.025;

        // Check if the user is eligible for free withdrawals
        if ($user->account_type === 'individual') {
            $currentDay = now()->dayOfWeek;
            $currentMonth = now()->month;

            // Each Friday withdrawal is free of charge
            if ($currentDay === 5) { // Friday is the 5th day of the week (0-indexed)
                return 0;
            }

            // The first 5K withdrawal each month is free
            $totalWithdrawalsThisMonth = $user->transactions()
                ->where('transaction_type', 'withdraw')
                ->whereMonth('date', $currentMonth)
                ->sum('amount');

            if ($totalWithdrawalsThisMonth <= 5000) {
                return 0;
            }

            // The first 1K withdrawal per transaction is free, and the remaining amount will be charged
            if ($amount <= 1000) {
                return 0;
            } else {
                $remainingAmount = $amount - 1000;
                return $remainingAmount * $withdrawalRate;
            }
        } elseif ($user->account_type === 'business') {
            // Decrease the withdrawal fee to 0.015% after a total withdrawal of 50K
            $totalWithdrawals = $user->transactions()
                ->where('transaction_type', 'withdraw')
                ->sum('amount');

            if ($totalWithdrawals >= 50000) {
                $withdrawalRate = 0.015;
            }
        }

        // Calculate the withdrawal fee
        return $amount * $withdrawalRate;
    }

}
