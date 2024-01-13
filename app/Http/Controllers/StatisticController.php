<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $userId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('amount', '>', 0)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('amount', '<', 0)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $balance = $totalIncome + $totalExpense;

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => abs($totalExpense), 
            'balance' => $balance,
        ]);
    }
}