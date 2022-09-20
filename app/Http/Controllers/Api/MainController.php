<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrimaryDataCollection;
use App\Http\Resources\SummaryCollection;
use App\Models\PrimaryData;
use App\Models\Summary;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

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

        $transactionToPrimaryData = Transaction
            ::where('transactions.user_id', $request->input('user', 0))
            ->whereYear('transactions.date', $request->input('year'))
            ->whereMonth('transactions.date', $request->input('month'))
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.type_id', Transaction::raw('SUM(amount) as amount'))
            ->groupBy('categories.type_id')
            ->get();

        $data['transactionPrimaryData'] = $transactionToPrimaryData;

        $summaryToPrimaryData = Summary
            ::where('summaries.user_id', $request->input('user', 0))
            ->whereYear('summaries.date', $request->input('year'))
            ->whereMonth('summaries.date', $request->input('month'))
            ->join('categories', 'summaries.category_id', '=', 'categories.id')
            ->select('categories.type_id', Summary::raw('SUM(planned_amount) as planned_amount'))
            ->groupBy('categories.type_id')
            ->get();

        $data['summaryPrimaryData'] = $summaryToPrimaryData;

        $data['primaryData'] = new PrimaryDataCollection(
            PrimaryData
                ::where('user_id', $request->input('user', 0))
                ->whereYear('date', $request->input('year'))
                ->whereMonth('date', $request->input('month'))
                ->join('users', 'user_id', '=', 'users.id')
                ->select('primary_data.*', 'users.name')
                ->get()
        );

        $tempTransaction = Transaction
            ::where('user_id', $request->input('user', 0))
            ->whereYear('date', $request->input('year'))
            ->whereMonth('date', $request->input('month'))
            ->select('category_id', Transaction::raw('SUM(amount) as amount'))
            ->groupBy('category_id');


        $data['summary'] = Summary
            ::where('summaries.user_id', $request->input('user', 0))
            ->whereYear('date', $request->input('year'))
            ->whereMonth('date', $request->input('month'))
            ->join('categories', 'summaries.category_id', '=', 'categories.id')
            ->leftJoinSub($tempTransaction, 'transactions', function ($join) {
                $join->on('summaries.category_id', '=', 'transactions.category_id');
            })
            ->select(
                'summaries.id',
                'summaries.user_id',
                'summaries.date',
                'summaries.category_id',
                'planned_amount',
                'transactions.amount',
                'title',
                'type_id'
            )
            ->get();

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
