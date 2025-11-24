@extends('layouts.layout')

<aside id="sidebar" class="sidebar d-flex flex-column">
  <ul class="sidebar-nav flex-grow-1" id="sidebar-nav">
      <li class="nav-item">
          <a class="nav-link @if(Request::segment(2) != 'dashboard') collapsed @endif" href="{{ url('/admin/dashboard') }}">
              <i class="bi bi-grid"></i>
              <span class="font-serif text-xl">{{__('Dashboard')}}</span>
          </a>
      </li><!-- End Dashboard Nav -->

      {{-- Only show for Admin role --}}
      @unlessrole('self_farmer')
      @role('Admin')
      <li class="nav-item">
          <a class="nav-link @if(Request::segment(1) != 'roles') collapsed @endif" href="{{ route('roles.index') }}">
            <i class="fa-brands fa-critical-role"></i>
              <span class="font-serif text-xl">{{__('Role Management')}}</span>
          </a>
      </li>
      @endrole
      @endunlessrole

    <li class="nav-item">
      <a class="nav-link @if(Request::segment(1) != 'weather') collapsed @endif" href="{{ route('weather.index') }}">
        <i class="fa-solid fa-cloud"></i>
          <span class="font-serif text-xl">{{__('Weather Data Management')}}</span>
      </a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if (Request::segment(1) != 'device_data') collapsed @endif" href="{{url('device_data')}}">
      <i class="fa-solid fa-camera-retro"></i>
        <span class="font-serif text-xl">{{__('Device Management')}}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if (Request::segment(1) != 'tabular') collapsed @endif" href="{{url('tabular')}}">
     <i class="fa-sharp fa-solid fa-database"></i>
        <span class="font-serif text-xl">{{__('Visualization of Data')}}</span>
    </a>
  </li>

  {{-- Hide these from self_farmer --}}
  @unlessrole('self_farmer')
  <li class="nav-item">
    <a class="nav-link @if (Request::segment(1) != 'farmers') collapsed @endif" href="{{url('farmers/index')}}">
      <i class="fa-duotone fa-solid fa-people-group"></i>
        <span class="font-serif text-xl">{{__('Farmer Management')}}</span>
    </a>
  </li>
  <li>
    <a class="nav-link @if (Request::segment(1) != 'cooperative') collapsed @endif" href="{{url('cooperatives')}}">
      <i class="bi bi-menu-button-wide"></i><span class="font-serif text-xl">{{__('Cooperative Management')}}</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link @if (Request::segment(1) != 'users') collapsed @endif" href="{{ route('users.index') }}">
      <i class="fa-solid fa-user-doctor"></i>
        <span class="font-serif text-xl">{{__('User Management')}}</span>
    </a>
  </li>
  @endunlessrole

  @role('naeb')
  <li class="nav-item">
    <a class="nav-link @if (Request::segment(1) != 'role') collapsed @endif" href="#">
      <i class="bi bi-envelope"></i>
      <span>{{__('National level Management')}}</span>
    </a>
  </li>
  @endrole
  </ul>
  <div class="ml-4">
    <i class="fa-sharp fa-solid fa-gear"></i>
    <a href="{{ route('settings.index') }}">
      <span class="font-serif text-2xl ">{{__('Settings')}}</span>
    </a>
  </div>
</aside><!-- End Sidebar -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-bsk4XhD3z+OKTprt+/+QsHgmuvMU6EM5txplnJsXxGOydaFBYDsU8U7CxrP+Ip5e" crossorigin="anonymous"></script>
