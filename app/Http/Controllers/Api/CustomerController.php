<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function customerList()
    {
        $customers = Customer::orderBy('name', 'ASC')
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customers
        ], Response::HTTP_OK);
    }

    public function customerCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required',
            'email'              => 'nullable|email',
            'phone_number'       => 'required|regex:/^[0-9]+$/',
            'alternative_number' => 'nullable|regex:/^[0-9]+$/',
            'address'            => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $input = [
            'name'               => $request->name ?? null,
            'email'              => $request->email ?? null,
            'phone_number'       => $request->phone_number ?? null,
            'alternative_number' => $request->alternative_number ?? null,
            'address'            => $request->address ?? null,
        ];

        $customer = Customer::create($input);

        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'Customer added successfully.'
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Try again later.'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function customerUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'        => 'required|exists:customers,id',
            'name'               => 'required',
            'email'              => 'nullable|email',
            'phone_number'       => 'required|regex:/^[0-9]+$/',
            'alternative_number' => 'nullable|regex:/^[0-9]+$/',
            'address'            => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $input = [
            'name'               => $request->name ?? null,
            'email'              => $request->email ?? null,
            'phone_number'       => $request->phone_number ?? null,
            'alternative_number' => $request->alternative_number ?? null,
            'address'            => $request->address ?? null,
        ];

        $customer = Customer::find($request->customer_id);

        if ($customer) {

            $customer->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully.'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Customer not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function customerDetails(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $customer = Customer::with([
            'loans.collections'
        ])->find($request->customer_id);

        if ($customer) {

            return response()->json([
                'success' => true,
                'data' => $customer
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Customer not found.'
        ], Response::HTTP_NOT_FOUND);
    }

    public function customerDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $customer = Customer::find($request->customer_id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.'
        ], Response::HTTP_OK);
    }
}
