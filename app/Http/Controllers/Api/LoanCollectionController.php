<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoanCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LoanCollectionController extends Controller
{
    public function collectionList()
    {
        $collections = LoanCollection::with(['customer', 'loan'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $collections
        ], Response::HTTP_OK);
    }

    public function collectionCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'loan_id'     => 'required|exists:loans,id',
            'date'        => 'required|date',
            'amount'      => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $input = [
            'customer_id'  => $request->customer_id ?? null,
            'loan_id'      => $request->loan_id ?? null,
            'date'         => $request->date ?? null,
            'amount'       => $request->amount ?? null,
        ];

        $collection = LoanCollection::create($input);

        if ($collection) {
            return response()->json([
                'success' => true,
                'message' => 'Loan collection added successfully.'
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Try again later.'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function collectionUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collection_id' => 'required|exists:loan_collections,id',
            'customer_id'   => 'required|exists:customers,id',
            'loan_id'       => 'required|exists:loans,id',
            'date'          => 'required|date',
            'amount'        => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $collection = LoanCollection::find($request->collection_id);

        $input = [
            'customer_id'    => $request->customer_id ?? null,
            'loan_id'        => $request->loan_id ?? null,
            'date'           => $request->date ?? null,
            'amount'         => $request->amount ?? null,
        ];

        if ($collection) {

            $collection->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Loan collection updated successfully.'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Loan collection not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function collectionDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collection_id' => 'required|exists:loan_collections,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $collection = LoanCollection::with(['customer', 'loan'])
            ->find($request->collection_id);

        if ($collection) {
            return response()->json([
                'success' => true,
                'data' => $collection
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Loan collection not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function collectionDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collection_id' => 'required|exists:loan_collections,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $collection = LoanCollection::find($request->collection_id);

        if (!$collection) {
            return response()->json([
                'success' => false,
                'message' => 'Collection not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $collection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Loan collection deleted successfully.'
        ], Response::HTTP_OK);
    }
}
