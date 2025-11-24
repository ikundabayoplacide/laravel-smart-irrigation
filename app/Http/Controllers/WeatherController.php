<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function index()
    {
        $weatherData = $this->fetchWeatherData();
        return view('weather.index', compact('weatherData'));
    }

    private function fetchWeatherData()
    {
        try {
            // Get user's IP address
            $ip = request()->ip();
            $city = 'Kigali'; // Default fallback

            // Check if not local environment for IP lookup
            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                try {
                    $locationResponse = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                    if ($locationResponse->successful() && $locationResponse['status'] === 'success') {
                        $city = $locationResponse['city'];
                    }
                } catch (\Exception $e) {
                    // Fallback to Kigali if IP lookup fails
                    Log::error("IP Lookup failed: " . $e->getMessage());
                }
            }

            $apiKey = 'e6263ec92d5b5931d3b061765a52c466';
            $response = Http::timeout(5)->get("http://api.openweathermap.org/data/2.5/weather?q={$city}&APPID={$apiKey}");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            // Return null if weather API fails
            return null;
        }
    }
}
