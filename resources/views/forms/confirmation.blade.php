<h3 class="card-title mb-4">{{ __('keywords.confirmation') }}</h3>

<div class="d-flex justify-content-between">
    <!-- User Info Section -->
    <div class="p-3 border rounded me-2" style="flex: 1;">
        <h5>{{ __('keywords.user_information') }}</h5> <hr>
        <p><strong>{{ __('keywords.name') }}:</strong> {{ $formData['name'] }}</p>
        <p><strong>{{ __('keywords.email') }}:</strong> {{ $formData['email'] }}</p>
        <p><strong>{{ __('keywords.phone_number') }}:</strong> {{ $formData['phone_number'] }}</p>
        <p><strong>{{ __('keywords.subscription_type') }}:</strong> {{ $formData['subscription_type'] }}</p>
    </div>

    <!-- Address Section -->
    <div class="p-3 border rounded me-2" style="flex: 1;">
        <h5>{{ __('keywords.address_information') }}</h5> <hr>
        <p><strong>{{ __('keywords.address_line_1') }}:</strong> {{ $formData['address_line_1'] }}</p>
        <p><strong>{{ __('keywords.address_line_2') }}:</strong> {{ $formData['address_line_2'] }}</p>
        <p><strong>{{ __('keywords.country') }}:</strong> {{ $this->getSelectedCountryName() }}</p>
        <p><strong>{{ __('keywords.city') }}:</strong> {{ $formData['city'] }}</p>
        <p><strong>{{ __('keywords.state') }}:</strong> {{ $formData['state'] }}</p>
        <p><strong>{{ __('keywords.postal_code') }}:</strong> {{ $formData['postal_code'] }}</p>
    </div>

    <!-- Payment Section -->
    @if($formData['subscription_type'] === 'premium')
    <div class="p-3 border rounded" style="flex: 1;">
        <h5>{{ __('keywords.payment_information') }}</h5> <hr>
        <p><strong>{{ __('keywords.credit_card_number') }}:</strong> {{ substr($formData['credit_card_number'], 0, 4) . ' **** **** ****' }}</p>
        <p><strong>{{ __('keywords.expiration_date') }}:</strong> {{ $formData['expiration_month'] . '/' . $formData['expiration_year'] }}</p>
        <p><strong>{{ __('keywords.cvv') }}:</strong> *** </p>
    </div>
    @endif
</div>

<div class="btn-group gap-2 mt-4">
    <button type="button" class="btn btn-secondary" wire:click="previousStep">{{ __('keywords.back') }}</button>
    <button type="button" class="btn btn-success" wire:click="submit">{{ __('keywords.submit') }}</button>
</div>
