<?php
namespace App\Repositories;
use App\Models\Country;


class CountriesRepository {

    public function index(){

        $columns = ['id', 'english_short_name' , 'calling_code', 'flag'];
        return Country::select($columns)
                        ->where('status', 'ACTIVE')
                        ->with('cities')
                        ->orderBy('english_short_name', 'ASC')
						->get();
    }

    public function findCountry($filters){

        $columns = ['id', 'english_short_name' , 'calling_code', 'flag'];
        return Country::select($columns)
            ->where($filters)
            ->where('status', 'ACTIVE')
            ->with('cities')
            ->orderBy('english_short_name', 'ASC')
            ->first();
    }
}
