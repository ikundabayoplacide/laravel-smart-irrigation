@extends('layouts.layout')

@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')

<style>
<style>
    .weather-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .weather-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px; /* Reduced radius */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Reduced shadow */
    }
    
    .weather-icon-large {
        width: 60px; /* Reduced from 80px */
        height: 60px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }
    
    .temp-display {
        font-size: 2rem; /* Reduced from 2.5rem */
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.2;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
        padding: 1rem; /* Reduced padding */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 40px; /* Reduced from 50px */
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem; /* Reduced font size */
    }
    
    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin-bottom: 1rem; /* Reduced margin */
    }
    
    .breadcrumb-modern li {
        color: #6b7280;
        font-size: 0.8rem;
    }
    
    .breadcrumb-modern li.active {
        color: #667eea;
        font-weight: 600;
    }
    
    .detail-row {
        padding: 0.5rem 0; /* Reduced padding */
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 1.5rem; /* Reduced padding */
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    h1.h3 { font-size: 1.5rem; }
    h2.h4 { font-size: 1.1rem; }
    h3.h2 { font-size: 1.75rem; }
</style>

<main id="main" class="main">
    <div class="container-fluid py-3"> <!-- Reduced vertical padding -->
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="h3 mb-2 font-weight-bold text-gray-800">
                <i class="fas fa-cloud-sun-rain mr-2"></i>
                {{ __('Weather Data Management') }}
            </h1>
            
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home mr-1"></i>{{ __('Home') }}
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Weather') }}
                    </li>
                </ol>
            </nav>
        </div>

        @if($weatherData)
            <!-- Main Weather Card -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="weather-card p-4"> <!-- Reduced padding from p-5 -->
                        <div class="row align-items-center">
                            <!-- Left Side - Main Info -->
                            <div class="col-lg-5 text-center text-lg-left mb-4 mb-lg-0 border-right-lg"> <!-- Changed col size and added border logic if needed, but keeping simple for now -->
                                <h2 class="h4 text-muted mb-1">{{ __('Current Weather Conditions') }}</h2>
                                <h3 class="h2 font-weight-bold mb-2">
                                    {{ $weatherData['name'] }}, {{ $weatherData['sys']['country'] }}
                                </h3>
                                <p class="text-muted mb-3">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ date('l, F j, Y') }}
                                </p>
                                
                                <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                                    <img src="http://openweathermap.org/img/w/{{ $weatherData['weather'][0]['icon'] }}.png" 
                                         alt="Weather icon" 
                                         class="weather-icon-large mr-3">
                                    <div>
                                        <div class="temp-display">
                                            {{ round($weatherData['main']['temp'] - 273.15, 1) }}°C
                                        </div>
                                        <p class="text-muted mb-0 small">
                                            {{ __('Feels like') }}: {{ round($weatherData['main']['feels_like'] - 273.15, 1) }}°C
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <h5 class="font-weight-bold text-capitalize mb-0" style="color: #667eea; font-size: 1.1rem;">
                                        {{ $weatherData['weather'][0]['description'] }}
                                    </h5>
                                </div>
                            </div>
                            
                            <!-- Right Side - Quick Stats -->
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="stat-icon mr-3">
                                                    <i class="fas fa-tint"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted mb-0 small">{{ __('Humidity') }}</p>
                                                    <h4 class="font-weight-bold mb-0 h5">{{ $weatherData['main']['humidity'] }}%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="stat-icon mr-3">
                                                    <i class="fas fa-wind"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted mb-0 small">{{ __('Wind Speed') }}</p>
                                                    <h4 class="font-weight-bold mb-0 h5">{{ $weatherData['wind']['speed'] }} m/s</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="stat-icon mr-3">
                                                    <i class="fas fa-compress-arrows-alt"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted mb-0 small">{{ __('Pressure') }}</p>
                                                    <h4 class="font-weight-bold mb-0 h5">{{ $weatherData['main']['pressure'] }} hPa</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="stat-icon mr-3">
                                                    <i class="fas fa-eye"></i>
                                                </div>
                                                <div>
                                                    <p class="text-muted mb-0 small">{{ __('Visibility') }}</p>
                                                    <h4 class="font-weight-bold mb-0 h5">{{ $weatherData['visibility'] / 1000 }} km</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="row">
                <!-- Atmospheric Details -->
                <div class="col-lg-6 mb-3">
                    <div class="weather-card p-3">
                        <h5 class="font-weight-bold mb-3 h6">
                            <i class="fas fa-cloud mr-2" style="color: #667eea;"></i>
                            {{ __('Atmospheric Details') }}
                        </h5>
                        
                        <div class="detail-row">
                            <span class="text-muted">
                                <i class="fas fa-compress-arrows-alt mr-2"></i>{{ __('Pressure') }}
                            </span>
                            <strong>{{ $weatherData['main']['pressure'] }} hPa</strong>
                        </div>
                        
                        <div class="detail-row">
                            <span class="text-muted">
                                <i class="fas fa-eye mr-2"></i>{{ __('Visibility') }}
                            </span>
                            <strong>{{ $weatherData['visibility'] / 1000 }} km</strong>
                        </div>
                        
                        <div class="detail-row">
                            <span class="text-muted">
                                <i class="fas fa-cloud mr-2"></i>{{ __('Cloudiness') }}
                            </span>
                            <strong>{{ $weatherData['clouds']['all'] }}%</strong>
                        </div>
                    </div>
                </div>
                
                <!-- Location Details -->
                <div class="col-lg-6 mb-3">
                    <div class="weather-card p-3">
                        <h5 class="font-weight-bold mb-3 h6">
                            <i class="fas fa-map-marker-alt mr-2" style="color: #667eea;"></i>
                            {{ __('Location Coordinates') }}
                        </h5>
                        
                        <div class="detail-row">
                            <span class="text-muted">
                                <i class="fas fa-globe mr-2"></i>{{ __('Longitude') }}
                            </span>
                            <strong>{{ $weatherData['coord']['lon'] }}</strong>
                        </div>
                        
                        <div class="detail-row">
                            <span class="text-muted">
                                <i class="fas fa-globe mr-2"></i>{{ __('Latitude') }}
                            </span>
                            <strong>{{ $weatherData['coord']['lat'] }}</strong>
                        </div>
                        
                        <div class="detail-row">
                            <span class="text-muted">
                                <i class="fas fa-city mr-2"></i>{{ __('Detected City') }}
                            </span>
                            <strong>{{ $weatherData['name'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Error State -->
            <div class="row">
                <div class="col-12">
                    <div class="weather-card p-5 text-center">
                        <i class="fas fa-exclamation-triangle fa-4x mb-4" style="color: #f59e0b;"></i>
                        <h3 class="h4 font-weight-bold mb-3">{{ __('Weather Data Unavailable') }}</h3>
                        <p class="text-muted mb-4">
                            {{ __('Unable to fetch weather data for your location. Please check your internet connection or try again later.') }}
                        </p>
                        <button class="btn btn-primary btn-lg" onclick="location.reload();">
                            <i class="fas fa-sync-alt mr-2"></i>{{ __('Retry') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>

@endsection