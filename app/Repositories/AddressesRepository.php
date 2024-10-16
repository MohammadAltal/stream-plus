<?php
namespace App\Repositories;

use App\Models\UserAddress;

class AddressesRepository {

    public function create($data){

        return UserAddress::create($data);

    }
}
