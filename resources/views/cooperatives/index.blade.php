@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')

<main id="main" class="main" style="height: 80vh">
    <p class="text-2xl font-serif font-bold underline">{{__('List Cooperatives')}}</p><br>
    <div class="row py-2">
        <div class="col-md-8">
    <a href="{{ route('cooperatives.create') }}" > <button class="btn btn-success text-md"><i class="fa-solid fa-plus m-2"></i>{{__('Add New Cooperative')}}</button></a><br><br>
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
                <th>{{ __('Location') }}</th>
                <th>{{ __('Services Offered') }}</th>
                <th>{{__('Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cooperatives as $cooperative)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $cooperative->name }}</td>
                <td> {{ $cooperative->location }}</td>
                <td>{{$cooperative->services_offered}}</td>
                <td class="flex gap-2">
                    <a href="{{ url('/cooperatives/' . $cooperative->id) }}" title="View Cooperative">
                        <button class="btn btn-info btn-sm">
                            <i class="fa fa-eye" aria-hidden="true"></i>{{ __('View') }}
                        </button>
                    </a>
                    @can('edit-user')
                    <a href="{{ url('/cooperatives/' . $cooperative->id . '/edit') }}" title="Edit Cooperative">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>{{ __('Edit') }}
                        </button>
                    </a>
                    @endcan
                    @can('delete-user')
                    <form method="POST" action="{{ url('/cooperatives/' . $cooperative->id) }}" accept-charset="UTF-8" style="display:inline" class="delete-form">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Cooperative">
                            <i class="fa fa-trash" aria-hidden="true"></i>{{ __('Delete') }}
                        </button>
                    </form>
                    @endcan
                </td>
            </tr>
                
            @endforeach
        </tbody>
    </table>
    <div class="row">
    <div class="col-md-12">
    <div class="flex float-end">
    {!! $cooperatives->links('pagination::bootstrap-5')!!}
</div>
</div>
</div>

</main>

@include('layouts.script')
@endsection
