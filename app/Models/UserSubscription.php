<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = [
        "start_date",
        "end_date",
        "payment_card_id",
        "user_id",
    ];
}
