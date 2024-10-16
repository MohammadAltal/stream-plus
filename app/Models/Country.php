<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Default values for attributes
     * @var  array an array with attribute as key and default as value
     */
    protected $attributes = [

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $visible = [
        'id',
        'english_short_name',
        'arabic_short_name',
        'name',
        'cities',
        'calling_code',
        'currency',
        'arabic_currency_short_name',
        'english_currency_short_name',
        'arabic_currency_name',
        'english_currency_name',
        'flag',
        'is_app'
    ];

    public function cities(){

        return $this->hasMany(City::class, 'country_id');
    }

}
