@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')
<div class="form-group">
    <label for="name">{{ __('Device Name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ old('name', $deviceData->name ?? '') }}" required>
</div>
<div class="form-group">
    <label for="device_id">Device ID</label>
    <input type="text" class="form-control" name="DEVICE_ID" value="{{ old('DEVICE_ID', $deviceData->DEVICE_ID ?? '') }}" required>
</div>
<div class="form-group">
    <label for="s_temp">S_TEMP</label>
    <input type="number" class="form-control" name="S_TEMP" value="{{ old('S_TEMP', $deviceData->S_TEMP ?? '') }}" required>
</div>
<div class="form-group">
    <label for="s_hum">S_HUM</label>
    <input type="number" class="form-control" name="S_HUM" value="{{ old('S_HUM', $deviceData->S_HUM ?? '') }}" required>
</div>
<div class="form-group">
    <label for="a_temp">A_TEMP</label>
    <input type="number" class="form-control" name="A_TEMP" value="{{ old('A_TEMP', $deviceData->A_TEMP ?? '') }}" required>
</div>
<div class="form-group">
    <label for="a_hum">A_HUM</label>
    <input type="number" class="form-control" name="A_HUM" value="{{ old('A_HUM', $deviceData->A_HUM ?? '') }}" required>
</div>
@include('layouts.script')