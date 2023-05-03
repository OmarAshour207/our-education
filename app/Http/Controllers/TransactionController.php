<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency'  => [
                'sometimes|required',
                Rule::in(['SAR', 'USD', 'EGP', 'AED', 'EUR'])
            ],
            'statusCode'    => [
                'sometimes|required',
                Rule::in([1, 2, 3])
            ],
            'lowAmount'  => 'sometimes|numeric',
            'highAmount' => 'sometimes|numeric',
            'startDate'  => 'sometimes|date',
            'endDate'    => 'sometimes|date'
        ]);

        if ($validator->fails())
            return response()->json(['success' => false, 'errors' => $validator->errors()]);


        $transactions = Transaction::when($request->query->get('statusCode'), function ($q, $statusCode) {
            return $q->where('statusCode', $statusCode);
        })->when($request->query->get('currency'), function ($q, $currency) {
            return $q->where('currency', $currency);
        })->when($request->query->get('lowAmount'), function ($q, $lowAmount) {
            return $q->where('paidAmount', '>=' , $lowAmount);
        })->when($request->query->get('highAmount'), function ($q, $highAmount) {
            return $q->where('paidAmount', '<=', $highAmount);
        })->when($request->query->get('startDate'), function ($q, $startDate) {
            return $q->whereDate('paymentDate', '>=', $startDate);
        })->when($request->query->get('endDate'), function ($q, $endDate) {
            return $q->whereDate('paymentDate', '<=', $endDate);
        })->get();

        return response()->json(['success' => true, 'transactions' => TransactionResource::collection($transactions)]);
    }
}
