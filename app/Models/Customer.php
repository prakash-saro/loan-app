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
        'email',
        'phone_number',
        'alternative_number',
        'address',
        'is_active',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanCollections()
    {
        return $this->hasMany(LoanCollection::class);
    }
}
