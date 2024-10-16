<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        "address_line_1",
        "address_line_2",
        "postal_code",
        "state_province",
        "country",
        "city",
        "country_id",
        "city_id",
        "user_id",
    ];

}
