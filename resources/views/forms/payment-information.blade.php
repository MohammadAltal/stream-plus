<h3 class="card-title mb-4">{{ __('keywords.payment_information') }}</h3>

@foreach (['credit_card_number', 'cvv'] as $field)
    <div class="mb-3">
        <!-- Label and Input inline with d-flex -->
        <div class="d-flex align-items-center">
            <label for="{{ $field }}" class="form-label me-2" style="min-width: 150px;">{{ __("keywords.$field") }}</label>
            <input type="text" class="form-control" id="{{ $field }}" wire:model="formData.{{ $field }}">
        </div>

        <!-- Error message displayed underneath the input -->
        @error("formData.$field")
        <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="mb-3">
    <!-- Label and Select inline with d-flex -->
    <div class="d-flex align-items-center">
        <label for="subscription_type" class="form-label me-2" style="min-width: 150px;">{{ __('keywords.expiration_date') }}</label>
        <select class="form-select me-2" id="expiration_month" wire:model="formData.expiration_month">
            <option value="" disabled selected>{{ __('keywords.month') }}</option>
            @foreach($months as $month)
                <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}</option>
            @endforeach
        </select>

        <select class="form-select" id="expiration_year" wire:model="formData.expiration_year">
            <option value="" disabled selected>{{ __('keywords.year') }}</option>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <!-- Error messages for month and year -->
    @error('formData.expiration_month')
    <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    @error('formData.expiration_year')
    <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="btn-group gap-2">
    <button type="button" class="btn btn-secondary" wire:click="previousStep">{{ __('keywords.back') }}</button>
    <button class="btn btn-danger" wire:click="nextStep">{{ __('keywords.next') }}</button>
</div>
