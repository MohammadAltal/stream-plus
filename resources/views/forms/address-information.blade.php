<h3 class="card-title mb-4">{{ __('keywords.address_information') }}</h3>

@foreach (['address_line_1', 'address_line_2'] as $field)
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
        <label for="country" class="form-label me-2" style="min-width: 150px;">{{ __('keywords.country') }}</label>
        <select class="form-select" id="country_id" wire:model="formData.country_id">
            <option value="" disabled selected>{{ __('keywords.select_your_country') }}</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->english_short_name }}</option>
            @endforeach
            <!-- Add more countries as needed -->
        </select>
    </div>

    <!-- Error message displayed underneath the select -->
    @error('formData.country')
    <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

@foreach ([ 'city', 'state', 'postal_code'] as $field)
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

<div class="btn-group gap-2">
    <button type="button" class="btn btn-secondary" wire:click="previousStep">{{ __('keywords.back') }}</button>
    <button class="btn btn-danger" wire:click="nextStep">{{ __('keywords.next') }}</button>
</div>
