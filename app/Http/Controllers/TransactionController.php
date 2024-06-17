<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;

class TransactionController extends Controller
{
    // Get all transactions
    public function index()
    {
        return Transaction::all();
    }

    // Upload a new transaction
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date_update' => 'required|date',
            'user' => 'required|string|max:255',
            'add_transaction' => 'required|integer',
            'withdraw_transaction' => 'required|integer',
        ]);

        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    // Get total amount of transactions
    public function getTotalAmount()
    {
        $total = DB::table('transactions')
                   ->select(DB::raw('SUM(add_transaction) - SUM(withdraw_transaction) as total_amount'))
                   ->first();

        return response()->json($total);
    }

     // Mendapatkan riwayat total transaksi tambahan bulanan dalam setahun
     public function getTotalAddYearly()
     {
         $yearlyAddTransactions = DB::table('transactions')
             ->select(DB::raw('MONTH(date_update) as month, SUM(add_transaction) as total_add'))
             ->whereYear('date_update', Carbon::now()->year)
             ->groupBy(DB::raw('MONTH(date_update)'))
             ->orderBy('month')
             ->get();
 
         return response()->json($yearlyAddTransactions);
     }
        // Mendapatkan riwayat total transaksi penarikan bulanan dalam setahun
        public function getTotalWithdrawYearly()
        {
            $yearlyWithdrawTransactions = DB::table('transactions')
                ->select(DB::raw('MONTH(date_update) as month, SUM(withdraw_transaction) as total_withdraw'))
                ->whereYear('date_update', Carbon::now()->year)
                ->groupBy(DB::raw('MONTH(date_update)'))
                ->orderBy('month')
                ->get();
    
            return response()->json($yearlyWithdrawTransactions);
        }

    // Get overall report
    public function getReport()
    {
        $report = DB::table('transactions')
                    ->select(DB::raw('category, SUM(add_transaction) as total_add, SUM(withdraw_transaction) as total_withdraw'))
                    ->groupBy('category')
                    ->get();

        return response()->json($report);
    }

    // Get monthly report
    public function getMonthlyReport()
    {
        $report = DB::table('transactions')
                    ->select(DB::raw('category, MONTH(date_update) as month, SUM(add_transaction) as total_add, SUM(withdraw_transaction) as total_withdraw'))
                    ->whereYear('date_update', Carbon::now()->year)
                    ->groupBy('category', DB::raw('MONTH(date_update)'))
                    ->get();

        return response()->json($report);
    }

    // Mendapatkan riwayat semua transaksi
    public function getTransactionHistory()
    {
        $transactions = Transaction::orderBy('date_update', 'desc')->get();
        return response()->json($transactions);
    }

    public function addTransactionHistory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'date_update' => 'required|date',
            'user' => 'required|string|max:255',
            'add_transaction' => 'required|integer',
        ]);

        try {
            $transaction = Transaction::create($request->all());
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create transaction'], 500);
        }
    }
}