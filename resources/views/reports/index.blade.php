@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ __('Reporting Management') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Reports') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Farmer Reports Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Farmer Reports') }}</h5>
                        <form action="{{ route('reports.generate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="farmers">
                            
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">{{ __('District') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="district">
                                        <option value="">{{ __('All Districts') }}</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district }}">{{ $district }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">{{ __('Gender') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="gender">
                                        <option value="">{{ __('All Genders') }}</option>
                                        <option value="male">{{ __('Male') }}</option>
                                        <option value="female">{{ __('Female') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">{{ __('Format') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="format">
                                        <option value="pdf">PDF</option>
                                        {{-- <option value="excel">Excel</option> --}}
                                    </select>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-download"></i> {{ __('Generate Report') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Device Reports Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Device Reports') }}</h5>
                        <form action="{{ route('reports.generate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="devices">

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="status">
                                        <option value="">{{ __('All Statuses') }}</option>
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">{{ __('Format') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="format">
                                        <option value="pdf">PDF</option>
                                        {{-- <option value="excel">Excel</option> --}}
                                    </select>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-download"></i> {{ __('Generate Report') }}
                                </button>
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
