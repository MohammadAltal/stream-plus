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
    private  $usersService;
    private  $countriesService;

    public function __construct() {
        $this->usersService = app(UsersService::class);
        $this->countriesService = app(CountriesService::class);
    }

    public function mount()
    {
        $this->initializeForm();
        $this->countries = $this->countriesService->index(); // Fetch countries using the service
        $this->months = range(1, 12); // Prepare months (1 to 12)
        $this->years = range(date('Y') + 1, date('Y') + 10); // Prepare years (next year to 10 years ahead)
    }

    private function initializeForm()
    {
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
    }

    // Dynamically get validation rules based on the current step
    protected function getRulesForStep($step)
    {
        $rules = [
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
            3 => [],
        ];

        if ($this->formData['subscription_type'] === 'premium' && $step === 3) {
            $rules[3] = [
                'formData.credit_card_number' => 'required|numeric|digits:16',
                'formData.expiration_month' => 'required',
                'formData.expiration_year' => 'required',
                'formData.cvv' => 'required|numeric|digits:3',
            ];
        }

        return $rules[$step];
    }

    // Get the selected country name based on the country_id
    public function getSelectedCountryName()
    {
        $country = collect($this->countries)->firstWhere('id', $this->formData['country_id']);
        return $country ? $country['english_short_name'] : '';
    }

    // Handle step transitions and manage skipping based on subscription type
    private function handleStepTransition($increment)
    {
        if ($this->formData['subscription_type'] === 'free' && $this->currentStep === 2 && $increment > 0) {
            $this->currentStep = 4; // Skip to confirmation
        } elseif ($this->formData['subscription_type'] === 'free' && $this->currentStep === 4 && $increment < 0) {
            $this->currentStep = 2; // Go back to address step
        } else {
            $this->currentStep += $increment;
        }
    }

    // Move to the next step
    public function nextStep()
    {
        // Validate the current step
        $this->validate($this->getRulesForStep($this->currentStep));

        // Handle step transition
        $this->handleStepTransition(1);
    }

    // Move to the previous step
    public function previousStep()
    {
        // Handle step transition backwards
        $this->handleStepTransition(-1);
    }

    public function submit()
    {
        try {
            // Register the user via the UsersService
            $this->usersService->register($this->formData);

            // Flash success message and reset the form to its initial state
            session()->flash('message', __('keywords.registration_completed_successfully'));

            // Reset the form data
            $this->initializeForm();
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
