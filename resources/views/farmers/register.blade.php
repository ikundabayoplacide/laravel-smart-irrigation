@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Farmer Registration') }}</h1>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Register New Farmer') }}</h5>

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

                            <form action="{{ route('farmers.store') }}" method="POST" class="mt-3">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" name="name" class="form-control" 
                                            value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" class="form-control" 
                                            value="{{ old('email') }}" required>
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
                                    <label for="phone" class="col-sm-3 col-form-label">{{ __('Phone') }}</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="phone" name="phone" class="form-control" 
                                            value="{{ old('phone') }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-sm-3 col-form-label">{{ __('Password') }}</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                <i class="fa fa-eye" id="password-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="confirm_password" class="col-sm-3 col-form-label">{{ __('Confirm Password') }}</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                                <i class="fa fa-eye" id="confirm_password-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ __('Gender') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender_male" 
                                                value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="gender_male">{{ __('Male') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender_female" 
                                                value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_female">{{ __('Female') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="device_id" class="col-sm-3 col-form-label">{{ __('Select Device') }}</label>
                                    <div class="col-sm-9">
                                        <select id="device_id" name="device_id" class="form-control" required>
                                            <option value="">{{ __('-- Choose Device --') }}</option>
                                            @foreach ($devices as $device)
                                                <option value="{{ $device->DEVICE_ID }}" {{ old('device_id') == $device->DEVICE_ID ? 'selected' : '' }}>
                                                    {{ $device->DEVICE_ID }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="cooperative_id" class="col-sm-3 col-form-label">{{ __('Select Cooperative') }}</label>
                                    <div class="col-sm-9">
                                        <select id="cooperative_id" name="cooperative_id" class="form-control">
                                            <option value="">{{ __('-- Choose Cooperative --') }}</option>
                                            @foreach ($cooperatives as $cooperative)
                                                <option value="{{ $cooperative->id }}" {{ old('cooperative_id') == $cooperative->id ? 'selected' : '' }}>
                                                    {{ $cooperative->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-user-plus me-1"></i> {{ __('Register') }}
                                        </button>
                                        <a class="btn btn-secondary ms-2" href="{{ route('farmers.index') }}">
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
