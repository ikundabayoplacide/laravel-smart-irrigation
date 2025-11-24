@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Add New Cooperative') }}</h1>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Cooperative Information') }}</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('cooperatives.store') }}" method="POST" class="mt-3">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" name="name" class="form-control" 
                                            value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="province" class="col-sm-3 col-form-label">{{ __('Province') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="province" name="province" class="form-control" 
                                            value="{{ old('province') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="district" class="col-sm-3 col-form-label">{{ __('District') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="district" name="district" class="form-control" 
                                            value="{{ old('district') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="sector" class="col-sm-3 col-form-label">{{ __('Sector') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="sector" name="sector" class="form-control" 
                                            value="{{ old('sector') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="cell" class="col-sm-3 col-form-label">{{ __('Cell') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="cell" name="cell" class="form-control" 
                                            value="{{ old('cell') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="device_id" class="col-sm-3 col-form-label">{{ __('Assign Device') }}</label>
                                    <div class="col-sm-9">
                                        <select id="device_id" name="device_id" class="form-control" required>
                                            <option value="">{{ __('-- Select Device --') }}</option>
                                            @foreach($devices as $device)
                                                <option value="{{ $device->DEVICE_ID }}" {{ old('device_id') == $device->DEVICE_ID ? 'selected' : '' }}>
                                                    {{ $device->DEVICE_ID }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ __('Services Offered') }}</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                        value="Agricultural Training" id="service1" 
                                                        {{ is_array(old('services')) && in_array('Agricultural Training', old('services')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="service1">
                                                        {{ __('Agricultural Training') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                        value="Seeds & Fertilizers Supply" id="service2"
                                                        {{ is_array(old('services')) && in_array('Seeds & Fertilizers Supply', old('services')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="service2">
                                                        {{ __('Seeds & Fertilizers Supply') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                        value="Crop Marketing" id="service3"
                                                        {{ is_array(old('services')) && in_array('Crop Marketing', old('services')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="service3">
                                                        {{ __('Crop Marketing') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                        value="Financial Services" id="service4"
                                                        {{ is_array(old('services')) && in_array('Financial Services', old('services')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="service4">
                                                        {{ __('Financial Services') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                        value="Equipment Rental" id="service5"
                                                        {{ is_array(old('services')) && in_array('Equipment Rental', old('services')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="service5">
                                                        {{ __('Equipment Rental') }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                        value="Storage Facilities" id="service6"
                                                        {{ is_array(old('services')) && in_array('Storage Facilities', old('services')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="service6">
                                                        {{ __('Storage Facilities') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-plus me-1"></i> {{ __('Add Cooperative') }}
                                        </button>
                                        <a class="btn btn-secondary ms-2" href="{{ route('cooperatives.index') }}">
                                            <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                                        </a>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.script')
@endsection
