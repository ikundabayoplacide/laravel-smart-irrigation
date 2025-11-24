@extends('layouts.layout')

@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')
    @include('layouts.graphData')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ __('Dashboard') }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Welcome Section -->
        <!-- <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body p-4">
                        <h2 class="text-white font-serif font-semibold text-2xl">{{ __('Welcome') }}, {{ Auth::user()->name }}!</h2>
                        <p class="text-white-50">{{ __('Monitor your farm data and weather conditions') }}</p>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- System Aggregate Section -->
        <p class="text-2xl font-serif font-semibold text-blue-800 m-2 text-center">{{ __('System Aggregate:') }}</p>
        <div class="grid grid-cols-1 gap-4 border-2 border-blue-500 border-collapse px-10 py-10 rounded mb-4">
            <a href="{{ url('device_data') }}" class="block">
                <div class="p-7 bg-red-500 text-white rounded hover:bg-red-700 cursor-pointer h-full">
                    <p class="font-serif font-bold text-2xl text-gray-200 text-center mb-3">{{ $deviceCount }}</p>
                    <p class="font-serif text-2xl font-semibold text-center">{{ __('My Devices') }}</p>
                </div>
            </a>
        </div>

        <!-- Device Data Representation Section -->
        <p class="text-2xl font-serif font-semibold text-yellow-700 m-4 text-center">{{ __('Device Data Representation:') }}</p>
        <div class="card-body border-2 border-yellow-500 mb-2 p-2 rounded">
            <div class="container">
                <form action="{{ route('admin.dashboard') }}" method="GET">
                    <div class="form-group">
                        <label for="device_id">{{ __('Select Device:') }}</label>
                        <select name="device_id" id="device_id" class="form-control">
                            <option value="">{{ __('--Choose Device--') }}</option>
                            @foreach ($deviceIDs as $deviceID)
                                <option value="{{ $deviceID }}" {{ $selectedDeviceID == $deviceID ? 'selected' : '' }}>
                                    {{ $deviceID }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Submit') }}</button>
                </form>
            </div>
            <h5 class="card-title">{{ __('Device') }} <span>{{ __('/Data Generations') }}</span></h5>
            <div id="reportsChart">{{ __('Historical device data') }}</div>
        </div>

        <!-- Graphical and Climate Data Section -->
        <p class="text-2xl font-serif font-semibold text-red-800 m-6 text-center">{{ __('Farm Monitoring Data:') }}</p>
        <div class="flex gap-2 border-2 border-red-800 rounded p-3">
            <div class="w-1/2">
                <p class="text-2xl font-serif font-semibold text-blue-800 m-2">{{ __('Graphical Representation:') }}</p>
                <div id="chart_div" style="width: 100%; height: 600px;"></div><br>
            </div>
            <div class="w-1/2">
                <div class="ml-30">
                    <p class="text-2xl font-serif font-semibold text-blue-700 mb-2">{{ __('Current Climate Data:') }}</p>
                    <div class="p-7 bg-blue-800 text-white rounded cursor-pointer">
                        @if($weatherData)
                            <h2 class="font-serif font-semibold text-2xl text-center mb-3">{{ __('Weather in') }}
                                {{ $weatherData['name'] }}</h2>
                            <table>
                                <thead>
                                    <tr class="border-2 border-spacing-2 p-5">
                                        <th class="border-2 font-semibold text-xl px-4 py-3">{{ __('Temperature') }}</th>
                                        <th class="border-2 font-semibold text-xl px-4 py-3">{{ __('Humidity') }}</th>
                                        <th class="border-2 font-semibold text-xl px-4 py-3">{{ __('Condition') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border-2">
                                            <p class="font-serif text-xl font-semibold text-center py-3">
                                                {{ round($weatherData['main']['temp'] - 273.15, 1) }} °C</p>
                                        </td>
                                        <td class="border-2">
                                            <p class="font-serif text-xl font-semibold text-center py-3">
                                                {{ $weatherData['main']['humidity'] }}%</p>
                                        </td>
                                        <td class="border-2">
                                            <p class="font-serif text-xl font-semibold text-center py-3">
                                                {{ $weatherData['weather'][0]['description'] }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-4">
                                <p class="font-serif font-semibold text-xl">{{ __('Weather data unavailable') }}</p>
                                <p class="text-sm mt-2">{{ __('Unable to fetch current weather data.') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Prediction Section -->
                    <div class="bg-blue-50 p-4 rounded-lg shadow-md mt-4">
                        <h4 class="text-2xl font-serif font-semibold text-blue-800 mt-6">{{__('Predictions')}}</h4>
                        <table class="table table-bordered mt-3">
                            <thead>
                               <tr>
                                <th>{{__('Sensor Measurement')}}</th>
                                <th>{{__('Predicted water amount')}}</th>
                               </tr>
                            </thead>
                            <tbody>
                                <td>[{{ implode(', ', $inputData) }}]</td>
                                <td>{{ $predictedIrrigation }} ltr</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Line Chart
        var chartData = @json($chartData);

        var timestamps = chartData.map(function(item) {
            return item.date;
        });
        var sTempData = chartData.map(function(item) {
            return item.S_TEMP;
        });
        var sHumData = chartData.map(function(item) {
            return item.S_HUM;
        });
        var aTempData = chartData.map(function(item) {
            return item.A_TEMP;
        });
        var aHumData = chartData.map(function(item) {
            return item.A_HUM;
        });
        var predHumData = chartData.map(function(item) {
            return item.PRED_AMOUNT;
        });

        var options = {
            series: [{
                name: 'Soil Temperature(°C)',
                data: sTempData
            }, {
                name: 'Soil Humidity(°C)',
                data: sHumData
            }, {
                name: 'Air Temperature(°C)',
                data: aTempData
            }, {
                name: 'Air Humidity(°C)',
                data: aHumData
            },{
                name:'Prediction amount (ltr)',
                data:predHumData
            }],
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1', '#2eca6a', '#ffc107', '#B91C1C','#000'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 1,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            xaxis: {
                type: 'datetime',
                categories: timestamps
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#reportsChart"), options);
        chart.render();
    </script>
@endsection
