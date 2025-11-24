@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')

    @include('layouts.aside')

    <main id="main" class="main">
        <p class="text-2xl font-serif font-semibold text-center">{{ __('Visualization of Data') }}</p>

        <div class="container d-flex">
            <form action="{{ route('device_data.display') }}" method="GET">
                <div class="form-group">
                    <label for="device_id">{{ __('Select Device:') }}</label>
                    <select name="device_id" id="device_id" class="form-control">
                        <option value="">{{ __('--Choose Device--') }}</option>
                        @foreach ($deviceIDs as $deviceID)
                            <option value="{{ $deviceID }}"
                                {{ $selectedDeviceID == $deviceID ? 'selected' : '' }}>
                                {{ $deviceID }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <button type="submit" class="btn btn-primary mt-3">{{ __('Submit') }}</button>
            </form>

        </div>

        <div class="mb-4 flex space-x-4 gap-3 float-end">
            <a href="{{ route('device_data.display', ['download' => 'pdf']) }}" class="btn btn-danger flex items-center space-x-2">
                <i class="fas fa-file-pdf"></i>
                <span>PDF</span>
            </a>
            <a href="{{ route('device_data.display', ['download' => 'excel']) }}" class="btn btn-success flex items-center space-x-2">
                <i class="fas fa-file-excel"></i>
                <span>Excel</span>
            </a>
            <a href="{{ route('device_data.display', ['download' => 'csv']) }}" class="btn btn-info flex items-center space-x-2">
                <i class="fas fa-file-csv"></i>
                <span>CSV</span>
            </a>
            <!-- <button id="copy-button" class="btn btn-gray flex items-center space-x-2">
                <i class="fa fa-copy"></i> Copy
            </button> -->
        </div>

        <section class="section">
            @if ($data->isEmpty())
                <p>{{ __('No device data found.') }}</p>
            @else
                <table id="data-table" class="table border-separate border-spacing-2 border">
                    <thead>
                        <tr>
                            <th class="border">{{ __('Device ID') }}</th>
                            <th class="border">{{ __('Sensor Temperature') }}</th>
                            <th class="border">{{ __('Sensor Humidity') }}</th>
                            <th class="border">{{ __('Ambient Temperature') }}</th>
                            <th class="border">{{ __('Ambient Humidity') }}</th>
                            <th class="border">{{ __('Prediction Irrigation amount') }}</th>
                        </tr>
                    </thead>
                    <tbody id="data-table-body">
                        @foreach ($data as $device_data)
                            <tr id="device-row-{{ $device_data->id }}">
                                <td class="border">{{ $device_data->DEVICE_ID }}</td>
                                <td class="border">{{ $device_data->S_TEMP }}</td>
                                <td class="border">{{ $device_data->S_HUM }}</td>
                                <td class="border">{{ $device_data->A_TEMP }}</td>
                                <td class="border">{{ $device_data->A_HUM }}</td>
                                <td class="border">{{ $device_data->PRED_AMOUNT }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex float-end">
                    {!! $data->links('pagination::bootstrap-5') !!}
                </div>
            @endif
        </section>
    </main>
    {{-- @include('layouts.footer') --}}
    @include('layouts.script')
@endsection
