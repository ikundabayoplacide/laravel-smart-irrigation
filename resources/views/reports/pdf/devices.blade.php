<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Device Report') }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #333; }
        .meta { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>{{ __('Device Report') }}</h1>
    
    <div class="meta">
        <p><strong>{{ __('Date:') }}</strong> {{ date('Y-m-d H:i:s') }}</p>
        @if(isset($filters['status']))
            <p><strong>{{ __('Status:') }}</strong> {{ $filters['status'] == 1 ? 'Active' : 'Inactive' }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ __('Device ID') }}</th>
                <th>{{ __('Farmer') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Soil Temp') }}</th>
                <th>{{ __('Soil Hum') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr>
                <td>{{ $device->DEVICE_ID }}</td>
                <td>{{ $device->farmer ? $device->farmer->name : 'Unassigned' }}</td>
                <td>{{ $device->device_state == 1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $device->S_TEMP }}</td>
                <td>{{ $device->S_HUM }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
