<?php
namespace App\Repositories;

use App\Models\UserSubscription;

class UserSubscriptions {

    public function create($data){

        return UserSubscription::create($data);

    }
}
