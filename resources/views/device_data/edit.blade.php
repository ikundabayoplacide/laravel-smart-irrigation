@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')
<main id="main" class="main" style="height: 80vh">
    <p class="text-2xl font-serif font-semibold text-center">{{__('Edit Device Data')}}</p>
    <form action="{{ route('device_data.update', ['device_data' => $device_data->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="device_state" value="{{ $device_data->device_state }}">
        <input type="hidden" name="on_off" value="{{ $device_data->on_off }}">
        <input type="hidden" name="PRED_AMOUNT" value="{{ $device_data->PRED_AMOUNT }}">

        <div class="form-group">
            <label for="name">{{__('Device Name')}}</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ old('name', $device_data->name) }}" required>
        </div>

        <div class="form-group">
            <label for="DEVICE_ID">{{__('Device ID')}}</label>
            <input type="text" class="form-control" id="DEVICE_ID" name="DEVICE_ID"
                value="{{ old('DEVICE_ID', $device_data->DEVICE_ID) }}" required>
        </div>

        <div class="form-group">
            <label for="S_TEMP">{{__('Sensor Temperature')}} (S_TEMP)</label>
            <input type="number" class="form-control" id="S_TEMP" name="S_TEMP"
                value="{{ old('S_TEMP', $device_data->S_TEMP) }}" required>
        </div>

        <div class="form-group">
            <label for="S_HUM">{{__('Sensor Humidity')}} (S_HUM)</label>
            <input type="number" class="form-control" id="S_HUM" name="S_HUM"
                value="{{ old('S_HUM', $device_data->S_HUM) }}" required>
        </div>

        <div class="form-group">
            <label for="A_TEMP">{{__('Ambient Temperature')}} (A_TEMP)</label>
            <input type="number" class="form-control" id="A_TEMP" name="A_TEMP"
                value="{{ old('A_TEMP', $device_data->A_TEMP) }}" required>
        </div>

        <div class="form-group">
            <label for="A_HUM">{{__('Ambient Humidity')}} (A_HUM)</label>
            <input type="number" class="form-control" id="A_HUM" name="A_HUM"
                value="{{ old('A_HUM', $device_data->A_HUM) }}" required>
        </div> <br>
        <a href="{{ route('device_data.index') }}" class="btn btn-secondary"> <i class="fa fa-arrow-left me-1"></i>{{__('Back')}}</a>
        <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
    </form>
</main>
@include('layouts.footer')
@include('layouts.script')
@endsection


