@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Edit Farmer Details') }}</h1>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Update Farmer Information') }}</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('farmers.update', ['farmers' => $farmers->id]) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" name="name" class="form-control" 
                                            value="{{ old('name', $farmers->name) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" class="form-control" 
                                            value="{{ old('email', $farmers->email) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="province" class="col-sm-3 col-form-label">{{ __('Province') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="province" name="province" class="form-control" 
                                            value="{{ old('province', $farmers->province) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="district" class="col-sm-3 col-form-label">{{ __('District') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="district" name="district" class="form-control" 
                                            value="{{ old('district', $farmers->district) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="sector" class="col-sm-3 col-form-label">{{ __('Sector') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="sector" name="sector" class="form-control" 
                                            value="{{ old('sector', $farmers->sector) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="cell" class="col-sm-3 col-form-label">{{ __('Cell') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="cell" name="cell" class="form-control" 
                                            value="{{ old('cell', $farmers->cell) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-3 col-form-label">{{ __('Phone') }}</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="phone" name="phone" class="form-control" 
                                            value="{{ old('phone', $farmers->phone) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="device_id" class="col-sm-3 col-form-label">{{ __('Select Device') }}</label>
                                    <div class="col-sm-9">
                                        <select id="device_id" name="device_id" class="form-control" required>
                                            <option value="">{{ __('-- Choose Device --') }}</option>
                                            @foreach ($devices as $device)
                                                <option value="{{ $device->DEVICE_ID }}" 
                                                    {{ (optional($farmers->deviceDate->first())->DEVICE_ID == $device->DEVICE_ID) ? 'selected' : '' }}>
                                                    {{ $device->DEVICE_ID }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="cooperative_id" class="col-sm-3 col-form-label">{{ __('Select Cooperative') }}</label>
                                    <div class="col-sm-9">
                                        <select id="cooperative_id" name="cooperative_id" class="form-control">
                                            <option value="">{{ __('-- Choose Cooperative --') }}</option>
                                            @foreach ($cooperatives as $cooperative)
                                                <option value="{{ $cooperative->id }}" 
                                                    {{ $farmers->cooperative_id == $cooperative->id ? 'selected' : '' }}>
                                                    {{ $cooperative->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save me-1"></i> {{ __('Update') }}
                                        </button>
                                        <a class="btn btn-secondary ms-2" href="{{ route('farmers.index') }}">
                                            <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
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


