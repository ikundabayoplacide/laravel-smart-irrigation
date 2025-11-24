
@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')
<main id="main" class="main">
<div class="container">
    <div class="card">
        <div class="card-header">
            <p class="text-2xl font-serif font-semibold text-center">{{__('Farmers Data Details')}}</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $farmers->id }}</td>
                </tr>
                <tr>
                    <th>{{__('Farmer ID')}}</th>
                    <td>{{ $farmers->name }}</td>
                </tr>
                <tr>
                    <th>{{__('Email')}}</th>
                    <td>{{ $farmers->email }}</td>
                </tr>
                <tr>
                    <th>{{__('District')}}</th>
                    <td>{{ $farmers->district }}</td>
                </tr>
                <tr>
                    <th>{{__('Phone')}}</th>
                    <td>{{ $farmers->phone }}</td>
                </tr>

                <tr>
                    <th>{{__('Created At')}}</th>
                    <td>{{ $farmers->created_at }}</td>
                </tr>
                <tr>
                    <th>{{__('Updated At')}}</th>
                    <td>{{ $farmers->updated_at }}</td>
                </tr>
            </table>

            <div class="btn-group" role="group">


                <form action="{{ route('farmers.destroy', $farmers->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('farmers.edit', $farmers->id) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>{{__('Edit')}}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash" ></i>{{__('Delete')}}</button>
                    <a href="{{ route('farmers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>{{__('Back to List')}}</a>
                </form>

                
            </div>
        </div>
    </div>
</div>
</main>

@include('layouts.script')
