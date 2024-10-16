<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentCard extends Model
{
    protected $fillable = [
        "holder_name",
        "number",
        "expiration_date",
        "cvv",
        "user_id",
    ];

    protected function casts(): array
    {
        return [
            'cvv' => 'hashed',
        ];
    }
}
