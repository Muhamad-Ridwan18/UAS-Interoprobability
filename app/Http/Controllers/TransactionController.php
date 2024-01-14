<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $transactions = $query->paginate(10);

        return response()->json($transactions);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'category_id' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'exists:users,id',
            'amount' => 'numeric',
            'category_id' => 'string',
            'description' => 'nullable|string',
            'date' => 'date',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
