@extends('layouts.layout')
@section('content')
<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        padding: 2rem;
    }

    .register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        width: 100%;
        overflow: hidden;
    }

    .register-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .register-header h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .register-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .register-body {
        padding: 2.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6b7280;
        transition: color 0.3s ease;
    }

    .toggle-password:hover {
        color: #10b981;
    }

    .radio-group {
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .radio-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .radio-label input {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
    }

    .btn-register {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .login-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .login-link a {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .login-link a:hover {
        color: #059669;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h2>{{ __('Create Account') }}</h2>
            <p>{{ __('Join AgriConnect Rwanda today') }}</p>
        </div>

        <div class="register-body">
            <form action="{{ route('user.register.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <!-- Name -->
                    <div class="form-group">
                        <label class="form-label">{{ __('Full Name') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500"/>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">{{ __('Email Address') }}</label>
                        <input type="email" class="form-control" name="email" placeholder="your@email.com" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500"/>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Phone -->
                    <div class="form-group">
                        <label class="form-label">{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control" name="phone" placeholder="+250 7XX XXX XXX" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-500"/>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label class="form-label">{{ __('Address') }}</label>
                        <input type="text" class="form-control" name="address" placeholder="Kigali, Rwanda" required>
                        <x-input-error :messages="$errors->get('address')" class="mt-2 text-red-500"/>
                    </div>
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label class="form-label">{{ __('Register As') }}</label>
                    <select class="form-control" name="role" required>
                        <option value="">{{ __('Select Your Role') }}</option>
                        <option value="cooperative_manager">{{ __('Cooperative Manager') }}</option>
                        <option value="self_farmer">{{ __('Self Farmer') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500"/>
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label class="form-label">{{ __('Gender') }}</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="gender" value="male" required>
                            <span>{{ __('Male') }}</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="female" required>
                            <span>{{ __('Female') }}</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2 text-red-500"/>
                </div>

                <div class="form-row">
                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">{{ __('Password') }}</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" name="password" id="password-field" placeholder="Enter password" required>
                            <span class="toggle-password" onclick="togglePassword('password-field', 'toggleIcon1')">
                                <i class="fa fa-eye" id="toggleIcon1"></i>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500"/>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm-field" placeholder="Confirm password" required>
                            <span class="toggle-password" onclick="togglePassword('password-confirm-field', 'toggleIcon2')">
                                <i class="fa fa-eye" id="toggleIcon2"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-register">
                    {{ __('Create Account') }} →
                </button>

                <!-- Login Link -->
                <div class="login-link">
                    <p>{{ __("Already have an account?") }} 
                        <a href="{{ route('admin.login') }}">{{ __('Login here') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@stop
