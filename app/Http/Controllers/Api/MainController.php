<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrimaryDataCollection;
use App\Http\Resources\SummaryCollection;
use App\Models\PrimaryData;
use App\Models\Summary;
use Illuminate\Http\Request;
use App\Models\Transaction;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = [];

        $data['primaryData'] = new PrimaryDataCollection(
            PrimaryData
                ::where('user_id', $request->input('user', 0))
                ->whereYear('date', $request->input('year'))
                ->whereMonth('date', $request->input('month'))
                ->join('users', 'user_id', '=', 'users.id')
                ->select('primary_data.*', 'users.name')
                ->get()
        );

        $data['summary'] = new SummaryCollection(
            Summary
                ::where('summaries.user_id', $request->input('user', 0))
                ->whereYear('date', $request->input('year'))
                ->whereMonth('date', $request->input('month'))
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select('summaries.*', 'categories.title')
                ->get()
        );

        $transactions = Transaction
            ::where('transactions.user_id', $request->input('user', 0))
            ->whereYear('date', $request->input('year'))
            ->whereMonth('date', $request->input('month'))
            ->get();

        $transactionArray = [];
        $transactionsMain = [];
        foreach ($transactions as $transaction) {
            if (array_key_exists($transaction->category_id, $transactionArray)) {
                $transactionArray[$transaction->category_id] += $transaction->amount;
            } else {
                $transactionArray[$transaction->category_id] = $transaction->amount;
            }
        };
        foreach ($transactionArray as $key => $value) {
            $transactionsMain[] = ['category_id' => $key, 'amount' => $value];
        }
        $data['transaction'] = $transactionsMain;

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
