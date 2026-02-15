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
        'total_amount',
        'cycle',
        'paying_amount',
        'from_date',
        'to_date',
        'is_active',
    ];

    protected $casts = [
        'loan_amount'     => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_amount'    => 'decimal:2',
        'paying_amount'   => 'decimal:2',
        'from_date'       => 'date',
        'to_date'         => 'date',
        'is_active'       => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($loan) {

            if (!$loan->isForceDeleting()) {
                $loan->collections()->delete();
            } else {
                $loan->collections()->withTrashed()->forceDelete();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function collections()
    {
        return $this->hasMany(LoanCollection::class);
    }
}
