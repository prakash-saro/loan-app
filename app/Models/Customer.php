<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone_number',
        'alternative_number',
        'address',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) {

            if (!$customer->isForceDeleting()) {

                $customer->loans()->each(function ($loan) {
                    $loan->delete();
                });
            } else {

                $customer->loans()->withTrashed()->each(function ($loan) {
                    $loan->forceDelete();
                });
            }
        });
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanCollections()
    {
        return $this->hasMany(LoanCollection::class);
    }
}
