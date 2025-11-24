@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Settings') }}</h1>
        </div>

        <section class="section">
            <div class="row">
                <!-- Profile Settings -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Profile Settings') }}</h5>
                            <p class="text-muted">{{ __('Manage your profile information and preferences') }}</p>
                            
                            <div class="list-group">
                                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-user me-2"></i> {{ __('Edit Profile') }}
                                </a>
                                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-lock me-2"></i> {{ __('Change Password') }}
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fa fa-envelope me-2"></i> {{ __('Email Settings') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Settings -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('System Settings') }}</h5>
                            <p class="text-muted">{{ __('Configure system preferences') }}</p>
                            
                            <div class="list-group">
                                <a href="{{ route('user.lang', ['lang' => app()->getLocale() == 'en' ? 'kiny' : 'en']) }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-language me-2"></i> {{ __('Language') }}
                                    <span class="badge bg-primary float-end">{{ app()->getLocale() == 'en' ? 'English' : 'Kinyarwanda' }}</span>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fa fa-bell me-2"></i> {{ __('Notifications') }}
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fa fa-shield me-2"></i> {{ __('Security') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Settings -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Application Information') }}</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>{{ __('Application Name') }}</th>
                                                <td>AgriConnect Rwanda</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Version') }}</th>
                                                <td>1.0.0</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Laravel Version') }}</th>
                                                <td>{{ app()->version() }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>{{ __('PHP Version') }}</th>
                                                <td>{{ phpversion() }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Environment') }}</th>
                                                <td><span class="badge bg-success">{{ app()->environment() }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Timezone') }}</th>
                                                <td>{{ config('app.timezone') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.script')
@endsection
