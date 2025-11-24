<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Farmer Report') }}</title>
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
    <h1>{{ __('Farmer Report') }}</h1>
    
    <div class="meta">
        <p><strong>{{ __('Date:') }}</strong> {{ date('Y-m-d H:i:s') }}</p>
        @if(isset($filters['district']))
            <p><strong>{{ __('District:') }}</strong> {{ $filters['district'] }}</p>
        @endif
        @if(isset($filters['gender']))
            <p><strong>{{ __('Gender:') }}</strong> {{ ucfirst($filters['gender']) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('District') }}</th>
                <th>{{ __('Gender') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($farmers as $farmer)
            <tr>
                <td>{{ $farmer->name }}</td>
                <td>{{ $farmer->email }}</td>
                <td>{{ $farmer->phone }}</td>
                <td>{{ $farmer->district }}</td>
                <td>{{ ucfirst($farmer->gender) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
