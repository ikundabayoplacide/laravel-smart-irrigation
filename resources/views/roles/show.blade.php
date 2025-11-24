@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')

    <main id="main" class="main" style="height: 80vh">
        <div class="pagetitle">
            <h1 class="text-2xl font-serif font-semibold text-center mb-4">{{ __('Show Role') }}</h1>
        </div>

        <section class="section profile">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <div class="row mb-3">
                                        <div class="col-lg-5 col-md-5 label font-bold">{{ __('Role Name:') }}</div>
                                        <div class="col-lg-7 col-md-7">{{ $role->name }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-5 col-md-5 label font-bold">{{ __('Permissions:') }}</div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (!empty($rolePermissions))
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($rolePermissions as $v)
                                                        <span class="badge bg-success">{{ $v->name }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('No permissions assigned') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <a class="btn btn-secondary" href="{{ route('roles.index') }}">
                                            <i class="fa fa-arrow-left me-1"></i>{{ __('Back') }}
                                        </a>
                                    </div>

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