<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function loanList()
    {
        $loans = Loan::with('customer')
            ->where('is_active', true)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $loans
        ], Response::HTTP_OK);
    }

    public function loanCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'      => 'required|exists:customers,id',
            'loan_amount'      => 'required|numeric|min:0',
            'interest_amount'  => 'required|numeric|min:0',
            'total_amount'     => 'required|numeric|min:0',
            'cycle'            => 'required|in:daily,weekly,monthly',
            'paying_amount'    => 'required|numeric|min:0',
            'from_date'        => 'required|date',
            'to_date'          => 'required|date|after_or_equal:from_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = [
            'customer_id'        => $request->customer_id ?? null,
            'loan_amount'        => $request->loan_amount ?? null,
            'interest_amount'    => $request->interest_amount ?? null,
            'total_amount'       => $request->total_amount ?? null,
            'cycle'              => $request->cycle ?? null,
            'paying_amount'      => $request->paying_amount ?? null,
            'from_date'          => $request->from_date ?? null,
            'to_date'            => $request->to_date ?? null,
        ];

        $loan = Loan::create($input);

        if ($loan) {
            return response()->json([
                'success' => true,
                'message' => 'Loan created successfully.'
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Try again later.'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function loanUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id'          => 'required|exists:loans,id',
            'customer_id'      => 'required|exists:customers,id',
            'loan_amount'      => 'required|numeric|min:0',
            'interest_amount'  => 'required|numeric|min:0',
            'total_amount'     => 'required|numeric|min:0',
            'cycle'            => 'required|in:daily,weekly,monthly',
            'paying_amount'    => 'required|numeric|min:0',
            'from_date'        => 'required|date',
            'to_date'          => 'required|date|after_or_equal:from_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = [
            'customer_id'        => $request->customer_id ?? null,
            'loan_amount'        => $request->loan_amount ?? null,
            'interest_amount'    => $request->interest_amount ?? null,
            'total_amount'       => $request->total_amount ?? null,
            'cycle'              => $request->cycle ?? null,
            'paying_amount'      => $request->paying_amount ?? null,
            'from_date'          => $request->from_date ?? null,
            'to_date'            => $request->to_date ?? null,
        ];

        $loan = Loan::find($request->loan_id);

        if ($loan) {
            $loan->update($input);
            return response()->json([
                'success' => true,
                'message' => 'Loan updated successfully.'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Loan not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function loanDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required|exists:loans,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $loan = Loan::with('customer')->find($request->loan_id);

        if ($loan) {
            return response()->json([
                'success' => true,
                'data' => $loan
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Loan not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function loanDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required|exists:loans,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $loan = Loan::find($request->loan_id);

        if (!$loan) {
            return response()->json([
                'success' => false,
                'message' => 'Loan not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $loan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Loan deleted successfully.'
        ], Response::HTTP_OK);
    }
}
