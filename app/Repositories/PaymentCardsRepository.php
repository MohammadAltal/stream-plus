<?php
namespace App\Repositories;

use App\Models\UserPaymentCard;

class PaymentCardsRepository {

    public function create($data){

        return UserPaymentCard::create($data);
    }
}
