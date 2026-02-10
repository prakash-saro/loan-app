<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function dashboardDetails()
    {
        $customers = Customer::count();
        $loans = Loan::count();

        $data = [
            'customers' => $customers,
            'loans' => $loans
        ];

        return response()->json([
            'success' => true,
            'data' => $data ?? []
        ], Response::HTTP_OK);
    }
}
