@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Edit Profile') }}</h1>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Profile Information Card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Profile Information') }}</h5>

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

                            <form action="{{ route('profile.update') }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" name="name" class="form-control" 
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" class="form-control" 
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-3 col-form-label">{{ __('Phone') }}</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="phone" name="phone" class="form-control" 
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-sm-3 col-form-label">{{ __('Address') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="address" name="address" class="form-control" 
                                            value="{{ old('address', $user->address) }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save me-1"></i> {{ __('Update Profile') }}
                                        </button>
                                        <a class="btn btn-secondary ms-2" href="{{ route('settings.index') }}">
                                            <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Card -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Change Password') }}</h5>

                            <form action="{{ route('profile.password.change') }}" method="POST" class="mt-3">
                                @csrf

                                <div class="row mb-3">
                                    <label for="current_password" class="col-sm-3 col-form-label">{{ __('Current Password') }}</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                                <i class="fa fa-eye" id="current_password-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="new_password" class="col-sm-3 col-form-label">{{ __('New Password') }}</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                                <i class="fa fa-eye" id="new_password-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="new_password_confirmation" class="col-sm-3 col-form-label">{{ __('Confirm New Password') }}</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                                <i class="fa fa-eye" id="new_password_confirmation-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa-solid fa-key me-1"></i> {{ __('Change Password') }}
                                        </button>
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
