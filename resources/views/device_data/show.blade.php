@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')
<main id="main" class="main" style="height: 80vh">
    <div class="card">
        <div class="card-header">
            <p class="text-2xl  text-center font-serif font-semibold">{{__('Device Data Details')}}</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $device_data->id }}</td>
                </tr>
                <tr>
                    <th>{{__('Device Name')}}</th>
                    <td>{{ $device_data->name }}</td>
                </tr>
                <tr>
                    <th>{{__('Device ID')}}</th>
                    <td>{{ $device_data->DEVICE_ID }}</td>
                </tr>

                <tr>
                    <th>Sensor Temperature (S_TEMP)</th>
                    <td>{{ $device_data->S_TEMP }}</td>
                </tr>
                <tr>
                    <th>Sensor Humidity (S_HUM)</th>
                    <td>{{ $device_data->S_HUM }}</td>
                </tr>
                <tr>
                    <th>Ambient Temperature (A_TEMP)</th>
                    <td>{{ $device_data->A_TEMP }}</td>
                </tr>
                <tr>
                    <th>Ambient Humidity (A_HUM)</th>
                    <td>{{ $device_data->A_HUM }}</td>
                </tr>
                <tr>
                    <th>{{__('Created At')}}</th>
                    <td>{{ $device_data->created_at }}</td>
                </tr>
                <tr>
                    <th>{{__('Updated At')}}</th>
                    <td>{{ $device_data->updated_at }}</td>
                </tr>
            </table>

            <div class="btn-group" role="group">
                <a href="{{ route('device_data.edit', $device_data->id) }}" class="btn btn-warning mr-2"> <i class="fa-solid fa-pen-to-square"></i>{{__('Edit')}}</a>

                <form action="{{ route('device_data.destroy', $device_data->id) }}" method="POST" style="display: inline-block;margin:0px 8px" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger "><i class="fa-solid fa-trash-can"></i>{{__('Delete')}}</button>
                </form>

                <a href="{{ route('device_data.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>{{__('Back')}}</a>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
@include('layouts.script')
@endsection
