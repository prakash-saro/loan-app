<?php

namespace App\Services;

use App\Models\Customer;

class CommonService
{
    public function customerCode()
    {
        $number = 1;

        while (true) {

            $code = 'CUS' . str_pad($number, 3, '0', STR_PAD_LEFT);

            $exists = Customer::where('code', $code)->exists();

            if (!$exists) {
                return $code;
            }

            $number++;
        }
    }
}
