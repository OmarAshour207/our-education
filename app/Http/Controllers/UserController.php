<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // get all user and be able to filter using specific currency
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency'  => [
                'sometimes',
                Rule::in(['SAR', 'USD', 'EGP', 'AED', 'EUR'])
            ]
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'users' => $validator->errors()]);

        $users = User::with('transactions')
            ->when($request->query->get('currency'), function ($q, $currency) {
                return $q->where('currency', $currency);
            })
            ->get();

        return response()->json(['users' => UserResource::collection($users), 'success' => true]);
    }
}
