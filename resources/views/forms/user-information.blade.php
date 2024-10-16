<div>
    <h3 class="card-title mb-4">{{ __('keywords.user_information') }}</h3>

    @foreach (['name', 'email', 'phone_number'] as $field)
        <div class="mb-3">
            <!-- Label and Input inline with d-flex -->
            <div class="d-flex align-items-center">
                <label for="{{ $field }}" class="form-label me-2" style="min-width: 150px;">{{ __("keywords.$field") }}</label>
                <input type="{{ $field === 'email' ? 'email' : 'text' }}" class="form-control" id="{{ $field }}" wire:model="formData.{{ $field }}">
            </div>

            <!-- Error message displayed underneath label and input -->
            @error("formData.$field")
            <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    @endforeach

    <div class="mb-3">
        <!-- Label and Select inline with d-flex -->
        <div class="d-flex align-items-center">
            <label for="subscription_type" class="form-label me-2" style="min-width: 150px;">{{ __('keywords.subscription_type') }}</label>
            <select class="form-select" id="subscription_type" wire:model="formData.subscription_type">
                <option value="free">{{ __('keywords.free') }}</option>
                <option value="premium">{{ __('keywords.premium') }}</option>
            </select>
        </div>

        <!-- Error message displayed underneath the select -->
        @error('formData.subscription_type')
        <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-grid">
        <button class="btn btn-danger btn-block" wire:click="nextStep">{{ __('keywords.next') }}</button>
    </div>
</div>
