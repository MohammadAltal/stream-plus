<?php
namespace App\Services;

use App\Repositories\AddressesRepository;
use App\Repositories\CountriesRepository;
use App\Repositories\UsersRepository;
use App\Repositories\PaymentCardsRepository;
use App\Repositories\UserSubscriptions;
use DateTime;
use DB;
use Exception;

class UsersService {

    protected $userRepository;
    protected $addressesRepository;
    protected $countriesRepository;
    protected $paymentCardsRepository;
    protected $userSubscriptions;

    public function __construct(
        UsersRepository  $userRepository,
        AddressesRepository $addressesRepository,
        CountriesRepository $countriesRepository,
        PaymentCardsRepository $paymentCardsRepository,
        UserSubscriptions $userSubscriptions
    ) {
        $this->userRepository = $userRepository;
        $this->addressesRepository =  $addressesRepository;
        $this->countriesRepository =  $countriesRepository;
        $this->paymentCardsRepository = $paymentCardsRepository;
        $this->userSubscriptions = $userSubscriptions;
    }

    /**
     * @throws Exception
     */
    public function register(array $data) {
        DB::transaction(function () use ($data) {
            $user = $this->userRepository->register($data);

            if (!$user) {
                throw new Exception(__('error_messages.user-not-created'));
            }

            $data['user_id'] = $user->id;

            // Create address
            $country = $this->countriesRepository->findCountry(['id' => $data['country_id']]);
            if (!$country) {
                throw new Exception(__('error_messages.country-not-found'));
            }
            $data['country'] = $country->english_short_name;
            $data['state_province']   = $data['state'];
            $this->addressesRepository->create($data);

            if ($data['subscription_type'] === 'premium') {
                $this->handlePremiumSubscription($data);
            }
        });
    }

    protected function handlePremiumSubscription(array $data) {
        // Create payment card
        $paymentCardData = [
            'holder_name' => $data['name'],
            'number' => $data['credit_card_number'],
            'cvv' => $data['cvv'],
            'user_id' => $data['user_id'],
            'expiration_date' => "{$data['expiration_year']}-{$data['expiration_month']}-01",
        ];

        $payment_card = $this->paymentCardsRepository->create($paymentCardData);

        // Create user subscription
        $currentDate = new DateTime();
        $subscriptionData = [
            'start_date' => $currentDate->format('Y-m-d'),
            'end_date' => $currentDate->modify('+1 year')->format('Y-m-d'),
            'payment_card_id' => $payment_card->id,
            'user_id' => $data['user_id'],
        ];

        $this->userSubscriptions->create(array_merge($data, $subscriptionData));
    }
}
