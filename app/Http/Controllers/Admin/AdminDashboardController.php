<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Cooperative;
use App\Models\DeviceData;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\Log;
use Phpml\Regression\LeastSquares;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Check if user is self_farmer and route to their dashboard
        if (Auth::user()->hasRole('self_farmer')) {
            return $this->selfFarmerDashboard($request);
        }

        // Fetch data for admin/cooperative_manager
        $data = $this->fetchDashboardData($request);

        // Pass data to view
        return view('admin.dashboard', $data);
    }

    private function selfFarmerDashboard(Request $request)
    {
        $selectedDeviceID = $request->input('device_id');
        
        // Get only device IDs assigned to this user
        $deviceIDs = DeviceData::where('user_id', Auth::id())
            ->select('DEVICE_ID')
            ->distinct()
            ->get()
            ->pluck('DEVICE_ID');
        
        // Count distinct devices for this user
        $deviceCount = $deviceIDs->count();
        
        $data = $this->fetchDeviceData($selectedDeviceID, Auth::id());
        $chartData = $this->prepareChartData($data);
        $weatherData = $this->fetchWeatherData();

        $dataMAchine = $this->updatePredictedIrrigation();
        $inputData = $dataMAchine['inputData'];
        $predictedIrrigation = $dataMAchine['predictedIrrigation'];

        return view('dashboards.self_farmer_dashboard', compact(
            'chartData',
            'inputData',
            'data',
            'weatherData',
            'selectedDeviceID',
            'predictedIrrigation',
            'deviceIDs',
            'deviceCount'
        ));
    }

    private function fetchDashboardData(Request $request)
    {
        $selectedDeviceID = $request->input('device_id');
        $deviceIDs = DeviceData::select('DEVICE_ID')->distinct()->get()->pluck('DEVICE_ID');
        $deviceNumber = $deviceIDs->count();
        $data = $this->fetchDeviceData($selectedDeviceID);
        $chartData = $this->prepareChartData($data);

        $this->handleUserCreation($request);

        $weatherData = $this->fetchWeatherData();
        $genderData = $this->fetchGenderData('users');
        $femaleCount = $genderData['female'];
        $farmerGenderData = $this->fetchGenderData('farmers');
        $deviceStateData = $this->fetchDeviceStateData();

        $countInStock = DeviceData::where('device_state', 3)
            ->distinct('DEVICE_ID')
            ->count('DEVICE_ID');

        $countFunction = DeviceData::where('device_state', 1)
            ->distinct('DEVICE_ID')
            ->count('DEVICE_ID');

        $countNon_function = DeviceData::where('device_state', 2)
            ->distinct('DEVICE_ID')
            ->count('DEVICE_ID');

        $users = User::all();
        $users = User::paginate(6);
        $farmers = Farmer::all();
        $devices = DeviceData::all();
        $cooperativeCount = Cooperative::count();
        $deviceCount = DeviceData::count();
        $farmerCount = Farmer::count();
        $userCount = User::count();

        $dataMAchine = $this->updatePredictedIrrigation();
        $inputData = $dataMAchine['inputData'];
        $predictedIrrigation = $dataMAchine['predictedIrrigation'];

        return compact(
            'chartData',
            'inputData',
            'data',
            'farmers',
            'users',
            'cooperativeCount',
            'deviceCount',
            'genderData',
            'weatherData',
            'deviceStateData',
            'farmerGenderData',
            'selectedDeviceID',
            'predictedIrrigation',
            'deviceIDs',
            'userCount',
            'countNon_function',
            'countFunction',
            'countInStock',
            'farmerCount',
            'deviceNumber'
        );
    }

    private function fetchDeviceData($selectedDeviceID, $userId = null)
    {
        $query = DeviceData::select('DEVICE_ID', 'S_TEMP', 'S_HUM', 'A_TEMP', 'A_HUM', 'created_at');
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        if ($selectedDeviceID) {
            $query->where('DEVICE_ID', $selectedDeviceID);
        }
        
        return $query->get();
    }

    private function prepareChartData($data)
    {
        return $data->map(function ($row) {
            return [
                'date' => $row->created_at->format('Y-m-d H:i:s'),
                'DEVICE_ID' => $row->DEVICE_ID,
                'S_TEMP' => $row->S_TEMP,
                'S_HUM' => $row->S_HUM,
                'A_TEMP' => $row->A_TEMP,
                'A_HUM' => $row->A_HUM,
            ];
        })->toArray();
    }

    private function handleUserCreation(Request $request)
    {
        if ($request->has(['name', 'email', 'password', 'role', 'address', 'phone', 'gender'])) {
            $inputitem = $request->all();
            User::create([
                'name' => $inputitem['name'],
                'email' => $inputitem['email'],
                'password' => Hash::make($inputitem['password']),
                'role' => $inputitem['role'],
                'address' => $inputitem['address'],
                'phone' => $inputitem['phone'],
                'gender' => $inputitem['gender'],
            ]);
        }
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

    private function fetchGenderData($table)
    {
        return DB::table($table)->select(
            DB::raw('gender as gender'),
            DB::raw('count(*) as number')
        )->groupBy('gender')
            ->get()
            ->reduce(function ($carry, $item) {
                $gender = strtolower($item->gender);
                if (isset($carry[$gender])) {
                    $carry[$gender] += $item->number;
                } else {
                    $carry[$gender] = $item->number;
                }
                return $carry;
            }, ['female' => 0, 'male' => 0]);
    }

    private function fetchDeviceStateData()
    {
        return DB::table('device_data')
            ->select(
                DB::raw('device_state as device_state'),
                DB::raw('count(distinct "DEVICE_ID") as number') // Count distinct DEVICE_IDs
            )
            ->groupBy('device_state')
            ->get()
            ->reduce(function ($carry, $item) {
                $carry[$item->device_state] = $item->number;
                return $carry;
            }, ['function' => 0, 'non_function' => 0, 'InStock' => 0]);
    }


    private function updatePredictedIrrigation()
    {
        $dataset_devices = DeviceData::all()->toArray();

        if (empty($dataset_devices)) {
            return [
                'inputData' => [],
                'predictedIrrigation' => null,
                'samples' => [],
                'targets' => []
            ];
        }

        $samples = [];
        $targets = [];

        // Prepare samples and targets for training
        foreach ($dataset_devices as $row) {
            // Only include rows with non-null PRED_AMOUNT
            if ($row['PRED_AMOUNT'] !== null) {
                $samples[] = [
                    $row['S_TEMP'],
                    $row['S_HUM'],
                    $row['A_TEMP'],
                    $row['A_HUM']
                ];
                $targets[] = $row['PRED_AMOUNT'];  // The target is the predicted irrigation amount
            }
        }

        // If no valid training data, return defaults
        if (empty($samples) || empty($targets)) {
            return [
                'inputData' => [],
                'predictedIrrigation' => null,
                'samples' => [],
                'targets' => []
            ];
        }

        // Train the regression model
        // Train the regression model
        try {
            $regression = new LeastSquares();
            $regression->train($samples, $targets);

            // Initialize inputData and predictedIrrigation variables
            $inputData = [];
            $predictedIrrigation = null;

            // Iterate over each row in the dataset and make predictions
            foreach ($dataset_devices as $row) {
                if (isset($row['S_TEMP'], $row['S_HUM'], $row['A_TEMP'], $row['A_HUM'])) {
                    $inputData = [
                        $row['S_TEMP'],
                        $row['S_HUM'],
                        $row['A_TEMP'],
                        $row['A_HUM']
                    ]; // Define inputData
                    $predictedIrrigation = $regression->predict($inputData);

                    // Update the DeviceData record with the predicted irrigation amount
                    DeviceData::where('id', $row['id'])  // Assuming the first column is the ID
                        ->update(['PRED_AMOUNT' => $predictedIrrigation]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Regression training failed: " . $e->getMessage());
            return [
                'inputData' => [],
                'predictedIrrigation' => null,
                'samples' => $samples,
                'targets' => $targets
            ];
        }

        // Optionally return the last prediction and other data for further processing
        return compact('predictedIrrigation', 'inputData', 'samples', 'targets');
    }
}
