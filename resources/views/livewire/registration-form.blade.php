<div class="container" style="@if($currentStep == 4) min-width: 500px; @else max-width: 500px;@endif">

    <div class="card p-4 shadow">
    <!-- Step Progress Indicator -->
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: calc(({{ $currentStep }} / 4) * 100%);" aria-valuenow="{{ $currentStep }}" aria-valuemin="1" aria-valuemax="4"></div>
    </div>

        <!-- Multi-Step Form Content -->
        @switch($currentStep)
            @case(1)
                @include('forms.user-information', ['formData' => $formData])
                @break

            @case(2)
                @include('forms.address-information', ['formData' => $formData])
                @break

            @case(3)
                @if ($formData['subscription_type'] === 'premium')
                    @include('forms.payment-information', ['formData' => $formData])
                @endif
                @break

            @case(4)
                @include('forms.confirmation', ['formData' => $formData])
                @break
        @endswitch
    </div>
    <!-- Display success message after submission -->
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif

    <!-- Display error message after submission -->
    @if (session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
</div>
