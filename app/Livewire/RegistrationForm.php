<?php

namespace App\Livewire;

use App\Services\UsersService;
use App\Services\CountriesService;
use Livewire\Component;

class RegistrationForm extends Component
{
    public $currentStep = 1;  // Track the current step
    public $formData = [];    // Store form data
    public $countries = [];   // Store countries list
    public $months = [];      // Store months (1-12)
    public $years = [];       // Store years (current year + 10)

    public function mount()
    {
        // Resolve the CountriesService
        $countriesService = app(CountriesService::class);
        $this->countries = $countriesService->index(); // Fetch countries using the service


        // Initialize form data with default values
        $this->formData = [
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'subscription_type' => 'free', // Default subscription type
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'postal_code' => '',
            'state' => '',
            'country_id' => '',
            'credit_card_number' => '',
            'expiration_month' => '',
            'expiration_year' => '',
            'cvv' => '',
        ];

        // Prepare months (1 to 12)
        $this->months = range(1, 12);

        // Prepare years (next year to 10 years ahead)
        $this->years = range(date('Y') + 1, date('Y') + 10);
    }

    // Validation rules for each step
    protected $rules = [
        1 => [
            'formData.name' => 'required|string|max:255',
            'formData.email' => 'required|email|unique:users,email',
            'formData.phone_number' => 'required|digits_between:10,15',
            'formData.subscription_type' => 'required|in:free,premium',
        ],
        2 => [
            'formData.address_line_1' => 'required|string|max:255',
            'formData.city' => 'required|string|max:100',
            'formData.postal_code' => 'required|string|max:20',
            'formData.state' => 'required|string|max:100',
            'formData.country_id' => 'required|integer|exists:countries,id',
        ],
        3 => [
            'formData.credit_card_number' => 'required_if:formData.subscription_type,premium|numeric|digits:16',
            'formData.expiration_month' => 'required_if:formData.subscription_type,premium',
            'formData.expiration_year' => 'required_if:formData.subscription_type,premium',
            'formData.cvv' => 'required_if:formData.subscription_type,premium|numeric|digits:3',
        ],
    ];

    // Get the selected country name based on the country_id
    public function getSelectedCountryName()
    {
        $country = collect($this->countries)->firstWhere('id', $this->formData['country_id']);
        return $country ? $country['english_short_name'] : '';
    }

    // Move to the next step and handle subscription type logic
    public function nextStep()
    {
        // Validate the current step
        $this->validate($this->rules[$this->currentStep]);

        // Move to the next step or skip to confirmation if Free subscription
        if ($this->currentStep === 2 && $this->formData['subscription_type'] === 'free') {
            $this->currentStep = 4; // Skip to confirmation
        } else {
            $this->currentStep++;
        }
    }

    // Move to the previous step
    public function previousStep()
    {
        // Handle previous step based on the subscription type
        if ($this->currentStep === 4 && $this->formData['subscription_type'] === 'free') {
            $this->currentStep = 2; // Go back to address step
        } else {
            $this->currentStep--;
        }
    }

    public function submit()
    {
        try {
            // Register the user via the UsersService
            $usersService = app(UsersService::class);
            $usersService->register($this->formData);

            // Flash success message and reset the form to its initial state
            session()->flash('message', __('keywords.registration_completed_successfully'));

            // Reset the form data
            $this->mount(); // Reinitialize form data
            $this->currentStep = 1;

        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());

        }
    }


    // Render the Livewire view
    public function render()
    {
        return view('livewire.registration-form');
    }
}
