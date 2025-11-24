@extends('layouts.layout')
@section('content')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        padding: 2rem;
    }

    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 450px;
        width: 100%;
        overflow: hidden;
    }

    .login-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .login-header h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .login-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .login-body {
        padding: 2.5rem;
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

    .btn-login {
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

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e5e7eb;
    }

    .divider span {
        background: white;
        padding: 0 1rem;
        position: relative;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .register-link a {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .register-link a:hover {
        color: #059669;
        text-decoration: underline;
    }

    .language-selector {
        margin-top: 1rem;
    }

    .language-selector select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .language-selector select:focus {
        outline: none;
        border-color: #667eea;
    }

    .role-option {
        padding: 0.5rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>{{ __('Welcome Back') }}</h2>
            <p>{{ __('Login to access your dashboard') }}</p>
        </div>

        <div class="login-body">
            <form action="{{ route('admin.check') }}" method="POST">
                @csrf
                
                @include('-message')

                <!-- Role Selection -->
                <div class="form-group">
                    <label class="form-label">{{ __('Login As') }}</label>
                    <select class="form-control" name="role" id="role-select" required>
                        <option value="">{{ __('Select Your Role') }}</option>
                        <option value="admin">{{ __('Admin') }}</option>
                        <option value="cooperative_manager">{{ __('Cooperative Manager') }}</option>
                        <option value="self_farmer">{{ __('Self Farmer') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500"/>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control" name="email" placeholder="your@email.com" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500"/>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">{{ __('Password') }}</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" name="password" id="password-field" placeholder="Enter your password" required>
                        <span class="toggle-password">
                            <i class="fa fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500"/>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    {{ __('Login') }} →
                </button>

                <!-- Language Selector -->
                <div class="language-selector">
                    <select id="languageSelect" class="form-control">
                        <option value="{{ route('user.lang', ['lang' => 'en']) }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                            🇬🇧 English
                        </option>
                        <option value="{{ route('user.lang', ['lang' => 'kiny']) }}" {{ app()->getLocale() == 'kiny' ? 'selected' : '' }}>
                            🇷🇼 Kinyarwanda
                        </option>
                    </select>
                </div>

                <!-- Register Link -->
                <div class="register-link">
                    <p>{{ __("Don't have an account?") }} 
                        <a href="{{ route('user.register') }}">{{ __('Register here') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Password toggle functionality
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const passwordField = document.querySelector('#password-field');
        const icon = document.querySelector('#toggleIcon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Language selector
    document.getElementById('languageSelect').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue) {
            window.location.href = selectedValue;
        }
    });
</script>
@stop
