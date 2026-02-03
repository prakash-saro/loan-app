<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loans';

    protected $fillable = [
        'customer_id',
        'loan_amount',
        'interest_amount',
        'cycle',
        'paying_amount',
        'is_active',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function collections()
    {
        return $this->hasMany(LoanCollection::class);
    }
}
