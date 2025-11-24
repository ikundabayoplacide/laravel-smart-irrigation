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
                    <li class="breadcrumb-item"><a href="index.html">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                </ol>
            </nav>
        </div>
        <p class="text-2xl font-serif font-semibold text-blue-800 m-2 text-center"> {{ __('System Aggregate:') }}</p>
        <div class="grid {{ Auth::user()->hasRole('Admin') ? 'grid-cols-4' : 'grid-cols-3' }} gap-4 border-2 border-blue-500 border-collapse px-10 py-10 rounded">
            @role('Admin')
            <a href="{{ route('users.index') }}" class="block">
                <div class="p-7 bg-blue-500 text-white rounded hover:bg-blue-700 cursor-pointer h-full">
                    <p class="font-serif font-bold text-2xl text-gray-200 text-center mb-3">{{ Auth::user()->count() }}</p>
                    <p class="font-serif text-2xl font-semibold text-center">{{ __('Users') }}</p>
                </div>
            </a>
            @endrole
            <a href="{{ route('farmers.index') }}" class="block">
                <div class="p-7 bg-green-500 text-white rounded hover:bg-green-700 cursor-pointer h-full">
                    <p class="font-serif font-bold text-2xl text-gray-200 text-center mb-3">{{ $farmerCount }}</p>
                    <p class="font-serif text-2xl font-semibold text-center">{{ __('Farmers') }}</p>
                </div>
            </a>
            <a href="{{ route('cooperatives.index') }}" class="block">
                <div class="p-7 bg-yellow-500 text-white rounded hover:bg-yellow-700 cursor-pointer h-full">
                    <p class="font-serif font-bold text-2xl text-gray-200 text-center mb-3">{{ $cooperativeCount }}</p>
                    <p class="font-serif text-2xl font-semibold text-center">{{ __('Cooperatives') }}</p>
                </div>
            </a>
            <a href="{{ route('device_data.index') }}" class="block">
                <div class="p-7 bg-red-500 text-white rounded hover:bg-red-700 cursor-pointer h-full">
                    <p class="font-serif font-bold text-2xl text-gray-200 text-center mb-3">{{ $deviceNumber }}</p>
                    <p class="font-serif text-2xl font-semibold text-center">{{ __('Devices') }}</p>
                </div>
            </a>
        </div>

        <p class="text-2xl font-serif font-semibold text-green-700 mt-10 text-center">{{ __('System Categories:') }}</p>
        <div class="grid {{ Auth::user()->hasRole('Admin') ? 'grid-cols-3' : 'grid-cols-2' }} gap-3 border-2 border-green-500 rounded py-10 h-96 mt-3">
            @role('Admin')
            <div class="border-none">
                <div class="h-60 w-60 ml-5">
                    <p class="font-serif font-semibold text-2xl ml-15 mt-4">{{ __('Users categories') }}</p>
                    <canvas id="chart-pie"></canvas>
                </div>
            </div>
            @endrole
            <div class="border-none">
                <div class="h-60 w-60 ml-5">
                    <p class="font-serif font-semibold text-2xl ml-15 mt-4">{{ __('Farmers categories') }}</p>
                    <canvas id="chart-pieFarmer"></canvas>
                </div>
            </div>
            <div class="border-none">
                <div class="h-60 w-60 ml-5">
                    <p class="font-serif font-semibold text-2xl ml-15 mt-4">{{ __('Device categories') }}</p>
                    <canvas id="chart-pieDevice"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Update Device Data Representation Section -->
        <p class="text-2xl font-serif font-semibold text-yellow-700 m-4 text-center">{{ __('Device Data Representation:') }}</p>
        <div class="card-body border-2 border-yellow-500 mb-2 p-2 rounded ">
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
        
        <!-- Add additional updates for other sections if needed -->
        
      
        <p class="text-2xl font-serif font-semibold text-red-800 m-6 text-center">{{ __('Other System Related Data:') }}
        </p>
        <div class="flex gap-2  border-2 border-red-800 rounded p-3">
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
                                                {{ $weatherData['main']['temp'] - 273.15 }} °C</p>
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
                    @role('Admin')
                    <p class="text-2xl font-serif font-semibold text-blue-800 mt-6">{{ __('Activated Users') }}</p>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Mobile') }}</th>
                                <th>{{ __('Payed') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <p>$220</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="flex float-end">
                        {{ $users->links() }}
                        </div>
                    @endrole
                    <div class="bg-blue-50 p-4 rounded-lg shadow-md">
                     <h4 class="text-2xl font-serif font-semibold text-blue-800 mt-6">{{__('Predictions')}}</h4>
                        <table class="table table-bordered mt-3">

                            <thead>
                               <tr>
                                <th>{{__('Sensor Measurement')}}</th>
                                <th>{{__('Predicted water amount')}}</th>
                               </tr>
                            </thead>
                            <tbody>
                                <td> [{{ implode(', ', $inputData) }}]</td>
                                <td>{{ $predictedIrrigation }} ltr</td>
                            </tbody>
                        </table>
                        {{-- <h1 class="text-orange-500 text-3xl font-bold mb-4">Irrigation Prediction Result</h1>
                        <p class="text-gray-700 text-lg mb-2">Recent Data from device(as input):
                            [{{ implode(', ', $inputData) }}]</p>
                        <p class="text-gray-900 text-xl font-semibold">Predicted Irrigation Amount:
                            {{ $predictedIrrigation }}</p> --}}
                    </div>

                </div>
            </div>

        </div>

    </main>

    {{-- @include('layouts.footer') --}}

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            // Pie Chart for Users
            var chartPieElement = document.getElementById('chart-pie');
            if (chartPieElement) {
                var ctx = chartPieElement.getContext('2d');
                var femaleCount = {{ $genderData['female'] }};
                var maleCount = {{ $genderData['male'] }};
                var totalCount = {{ $genderData['male'] + $genderData['female'] }};
                var dataPie = {
                    type: 'pie',
                    data: {
                        labels: ["Female (" + femaleCount + "/" + totalCount + ")", "Male (" + maleCount + "/" +
                            totalCount + ")"
                        ],
                        datasets: [{
                            data: [femaleCount, maleCount],
                            backgroundColor: ["rgba(6, 182, 212, 1)", "rgba(4, 120, 87)"],
                        }],
                    },
                };
                new Chart(ctx, dataPie);
            }

            // Pie Chart for Farmers
            var ctxFarmers = document.getElementById('chart-pieFarmer').getContext('2d');
            var femaleFarmer = {{ $farmerGenderData['female'] }};
            var maleFarmer = {{ $farmerGenderData['male'] }};
            var totalFarmerCount = {{ $farmerGenderData['male'] + $farmerGenderData['female'] }};
            var dataPieFarmer = {
                type: "pie",
                data: {
                    labels: ["Female(" + femaleFarmer + "/" + totalFarmerCount + ")", "Male(" + maleFarmer +
                        "/" + totalFarmerCount + ")"
                    ],
                    datasets: [{
                        data: [femaleFarmer, maleFarmer],
                        backgroundColor: ["rgba(255, 193, 7, 1)", "rgba(244, 67, 54, 1)"],
                    }],
                },
            };
            new Chart(ctxFarmers, dataPieFarmer);
        });

        $(document).ready(function() {
    // Pie Chart for Devices
    var ctxDevice = document.getElementById('chart-pieDevice').getContext('2d');
    var FunctionDevice = {{ $countFunction }};
    var nonFunctionDevice = {{ $countNon_function }};
    var InStock = {{ $countInStock }};
    var TotalDevice = {{ $deviceNumber }};
    var dataPieDevice = {
        type: "pie",
        data: {
            labels: [
                "Functional Device (" + FunctionDevice + "/" + TotalDevice + ")",
                "NonFunctional Device (" + nonFunctionDevice + "/" + TotalDevice + ")",
                "Device In Stock (" + InStock + "/" + TotalDevice + ")"
            ],
            datasets: [{
                data: [FunctionDevice, nonFunctionDevice, InStock],
                backgroundColor: [
                    "rgba(4, 120, 87)",
                    "rgba(255, 193, 7, 1)",
                    "rgba(244, 67, 54, 1)"
                ],
            }],
        },
    };
    new Chart(ctxDevice, dataPieDevice);

    // Other chart initializations here...
});


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
                    opacityTo: 1,//0.4
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
