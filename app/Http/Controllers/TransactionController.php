<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())->with('user')->orderBy('id', 'desc')->paginate();
        return view('transactions', compact('transactions'));
    }

    public function depositIndex()
    {
        $transactions = Transaction::where('transaction_type', Transaction::TYPE_DEPOSIT)
            ->where('user_id', auth()->id())
            ->with('user')
            ->orderBy('id', 'desc')->paginate();
        return view('deposits', compact('transactions'));
    }

    public function depositStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
        ]);

        try {
            $user = User::find($request->user_id);

            DB::beginTransaction();

            Transaction::create([
                'user_id' => $request->user_id,
                'transaction_type' => Transaction::TYPE_DEPOSIT,
                'amount' => $request->amount,
                'date' => now(),
            ]);

            $user->increment('balance', $request->amount);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return redirect()->back()->with('message', 'Can not store deposit request.');
        }

        return redirect()->route('deposits.index')->with('message', 'Deposit request applied successfully.');
    }

    public function withdrawIndex()
    {
        $transactions = Transaction::where('transaction_type', Transaction::TYPE_WITHDRAWAL)
            ->where('user_id', auth()->id())
            ->with('user')
            ->orderBy('id', 'desc')->paginate();
        return view('withdrawals', compact('transactions'));
    }

    public function withdrawStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
        ]);

        try {
            $user = User::find($request->user_id);

            DB::beginTransaction();

            $amount = $request->amount;
            $withdrawalFee = $this->calculateWithdrawalFee($user, $amount);

            if ($user->balance < ($amount + $withdrawalFee)) {
                return redirect()->back()->with('message', 'Can not withdraw because of insufficient balance.');
            }

            Transaction::create([
                'user_id' => $request->user_id,
                'transaction_type' => Transaction::TYPE_WITHDRAWAL,
                'amount' => $amount,
                'fee' => $withdrawalFee,
                'date' => now(),
            ]);

            $user->decrement('balance', $amount + $withdrawalFee);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();

            return redirect()->back()->with('message', 'Can not store withdrawal request.');
        }

        return redirect()->route('withdraw.index')->with('message', 'Withdrawal request applied successfully.');
    }

    private function calculateWithdrawalFee($user, $amount)
    {
        $withdrawalFee = 0;
        if ($user->account_type == User::TYPE_INDIVIDUAL) {
            if (now()->isFriday() && $amount <= 1000) {
                return $withdrawalFee;
            }

            $userWithdrawalsThisMonth = Transaction::where('user_id', $user->id)
                ->where('transaction_type', 'withdrawal')
                ->whereMonth('date', now()->month)
                ->sum('amount');

            if (($userWithdrawalsThisMonth + $amount) <= 5000) {
                return $withdrawalFee;
            }

            $withdrawalFee = ($amount - 1000) * 0.015;
        } elseif ($user->account_type == User::TYPE_BUSINESS) {
            $userTotalWithdrawals = Transaction::where('user_id', $user->id)
                ->where('transaction_type', 'withdrawal')
                ->sum('amount');

            if ($userTotalWithdrawals > 50000) {
                $withdrawalFee = $amount * 0.015;
            } else {
                $withdrawalFee = $amount * 0.025;
            }
        }

        return $withdrawalFee;
    }
}
