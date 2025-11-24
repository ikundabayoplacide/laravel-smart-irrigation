
@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Cooperative Details') }}</h1>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cooperative->name }}</h5>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-bold">{{ __('Province:') }}</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $cooperative->province ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-bold">{{ __('District:') }}</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $cooperative->district ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-bold">{{ __('Sector:') }}</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $cooperative->sector ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-bold">{{ __('Cell:') }}</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $cooperative->cell ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-bold">{{ __('Services Offered:') }}</label>
                                <div class="col-sm-9">
                                    <div class="mt-2">
                                        @if($cooperative->services_offered)
                                            @foreach(explode(', ', $cooperative->services_offered) as $service)
                                                <span class="badge bg-primary me-2 mb-2">{{ $service }}</span>
                                            @endforeach
                                        @else
                                            <p class="form-control-plaintext">{{ __('No services listed') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label fw-bold">{{ __('Created:') }}</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $cooperative->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <a href="{{ route('cooperatives.edit', $cooperative) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('cooperatives.destroy', $cooperative) }}" method="POST" 
                                        class="d-inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash me-1"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                    <a href="{{ route('cooperatives.index') }}" class="btn btn-secondary ms-2">
                                        <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.script')
@endsection
