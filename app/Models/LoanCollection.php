<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanCollection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_collections';

    protected $fillable = [
        'customer_id',
        'loan_id',
        'date',
        'amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
