@extends('layouts.layout')

@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')

<main id="main" class="main" style="height: 80vh">
    <h1 class="text-2xl mb-2 font-serif font-semibold text-center">{{ __('List Of All Users') }}</h1>
   
    <div class="row py-2">
        <div class="col-md-8">
            @can('create-user')
            <a class="btn btn-success btn-sm mb-2 float-start" href="{{ route('admin.register') }}">
                <i class="fa fa-plus"></i>{{ __('Create New User') }}
            </a>
            @endcan
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <form action="/searching" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="search...." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Role') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Mobile') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        @if ($item->roles->isNotEmpty())
                            {{ implode(', ', $item->roles->pluck('name')->toArray()) }}
                        @else
                            {{ __('No Role') }}
                        @endif
                    </td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        <a href="{{ url('/users/' . $item->id) }}" title="View User">
                            <button class="btn btn-info btn-sm">
                                <i class="fa fa-eye" aria-hidden="true"></i>{{ __('View') }}
                            </button>
                        </a>
                        @can('edit-user')
                        <a href="{{ url('/users/' . $item->id . '/edit') }}" title="Edit User">
                            <button class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>{{ __('Edit') }}
                            </button>
                        </a>
                        @endcan
                        @can('delete-user')
                        <form method="POST" action="{{ url('/users/' . $item->id) }}" accept-charset="UTF-8" style="display:inline" class="delete-form">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete User">
                                <i class="fa fa-trash" aria-hidden="true"></i>{{ __('Delete') }}
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex float-end">
    {!! $users->links('pagination::bootstrap-5') !!}
    </div>
    <div class="d-flex justify-content-between align-items-center float-end">
        {{-- <div>
            <a href="{{ route('users.download', ['download' => 'pdf']) }}" class="btn btn-primary">Download PDF</a>
            <a href="{{ route('users.download', ['download' => 'excel']) }}" class="btn btn-success">Download Excel</a>
        </div> --}}
       
    </div>
</main>

@include('layouts.script')
@endsection
