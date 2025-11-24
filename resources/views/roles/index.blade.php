@extends('layouts.layout')
@section('content')
    @include('layouts.head-part')
    @include('layouts.header-content')
    @include('layouts.aside')
    <main id="main" class="main">
        <h2 class="text-2xl font-serif font-semibold text-center">{{ __('Role Management') }}</h2>
        <div class="row py-2">
            <div class="col-md-8">
                
                    @can('role-create')
                        <a class="btn btn-success btn-sm mb-3 text-md" href="{{ route('roles.create') }}"><i
                                class="fa fa-plus"></i> {{ __('Create New Role') }}</a>
                    @endcan
           
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <form action="/searches" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="search...." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th width="100px">{{ __('No') }}</th>
                <th>{{ __('Name') }}</th>
                <th width="280px">{{ __('Action') }}</th>
            </tr>
            @php $i = ($roles->currentPage() - 1) * $roles->perPage(); @endphp

            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><i
                                class="fa-solid fa-list"></i> {{ __('Show') }}</a>
                        @can('role-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}"><i
                                    class="fa-solid fa-pen-to-square"></i>{{ __('Edit') }}</a>
                        @endcan
                        @can('role-delete')
                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-danger btn-sm ">
                                    <i class="fa-solid fa-trash"></i>{{ __('Delete') }}</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $roles->links('pagination::bootstrap-5') !!}

    </main>
    @include('layouts.script')
@endsection
