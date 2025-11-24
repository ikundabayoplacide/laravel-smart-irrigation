
@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')
<main id="main" class="main" style="height: 80vh">
    <div class="container">
        <h1 class="text-2xl font-serif font-semibold my-4">{{__('Assignment Details')}}</h1>

        <!-- Display Success Message if exists -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Check if there is any assignment data -->
        @if(!empty($details))
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>{{__('Farmer Name')}}</th>
                        <th>{{__('Cooperative Name')}}</th>
                        <th>{{__('Location')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $detail)
                    <tr>
                        <td>{{ $detail['member_name'] }}</td>
                        <td>{{ $detail['cooperative_name'] }}</td>
                        <td>{{ $detail['location'] }}</td>
                        <td>
                            <a href="{{ url('/details/' . $detail->id) }}" title="View Cooperative">
                                <button class="btn btn-info btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>{{ __('View') }}
                                </button>
                            </a>
                            @can('edit-user')
                            <a href="{{ url('/details/' . $detail->id . '/edit') }}" title="Edit Cooperative">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>{{ __('Edit') }}
                                </button>
                            </a>
                            @endcan
                            @can('delete-user')
                            <form method="POST" action="{{ url('/details/' . $detail->id) }}" accept-charset="UTF-8" style="display:inline" class="delete-form">
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
        @else
            <p>No assignment data available. Please assign a farmer to a cooperative first.</p>
        @endif

        <!-- Link to go back to the assignment form -->
        <a href="{{ route('cooperatives.index') }}" class="btn btn-primary mt-4">{{__('Assign Another Farmer')}}</a>
    </div>
</main>

@include('layouts.script')
