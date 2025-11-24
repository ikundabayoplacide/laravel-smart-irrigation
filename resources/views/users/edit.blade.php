@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')

<main id="main" class="main" style="height: 80vh">
    <div class="pagetitle">
        <h1 class="text-2xl font-serif font-semibold">{{__('Edit User')}}</h1>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{__('User Information')}}</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{__('Whoops!')}}</strong> {{__('There were some problems with your input.')}}
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ url('users/' .$user->id) }}" method="post" class="mt-3">
                            {!! csrf_field() !!}
                            @method("PUT")
                            <input type="hidden" name="id" value="{{$user->id}}" />

                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">{{__('Name')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" id="name" value="{{old('name', $user->name)}}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">{{__('Email')}}</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role" class="col-sm-3 col-form-label">{{__('Role')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="role" id="role" value="{{$user->role}}" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-3 col-form-label">{{__('Address')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="address" id="address" value="{{old('address', $user->address)}}" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-sm-3 col-form-label">{{__('Phone')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="phone" id="phone" value="{{old('phone', $user->phone)}}" class="form-control">
                                </div>
                            </div>

                            @if($user->role === 'self_farmer')
                            <div class="row mb-3">
                                <label for="device_id" class="col-sm-3 col-form-label">{{__('Assign Device')}}</label>
                                <div class="col-sm-9">
                                    <select name="device_id" id="device_id" class="form-control">
                                        <option value="">{{ __('-- No Device Assigned --') }}</option>
                                        @foreach($devices as $device)
                                            <option value="{{ $device->DEVICE_ID }}" 
                                                {{ (old('device_id', $assignedDevice->DEVICE_ID ?? '') == $device->DEVICE_ID) ? 'selected' : '' }}>
                                                {{ $device->DEVICE_ID }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{__('Select a device to assign to this self-farmer user')}}</small>
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa-solid fa-save me-1"></i> {{__('Update')}}
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
                                        <i class="fa fa-arrow-left me-1"></i> {{__('Back')}}
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('layouts.script')
@endsection