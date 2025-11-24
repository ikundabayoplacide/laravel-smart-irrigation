@extends('layouts.layout')
@section('content')
@include('layouts.head-part')
@include('layouts.header-content')
@include('layouts.aside')
@section('content')

        <div class="flex justify-center">

            <form action= "{{ route('admin.register') }}" method="post" class="bg-slate-300 rounded p-40">
                {!! csrf_field() !!}
                <p class="text-center text-3xl font-serif text-red-500 underline" style="margin-bottom:30px">{{__('Register Form')}}</p>
               <div class="grid grid-cols-2 gap-4">
                <div>
                <label class="font-bold font-serif">{{__('First Name')}}</label>
                <input type="text" name="name" id="name" class="flex w-80 h-3 p-4 rounded"> </br>
              
                </div>
                 <div>
                <label class="font-bold font-serif">{{__('Email')}}</label>
                <input type="email" name="email" id="email" class="flex w-80 h-3 p-4 rounded"> </br>

                </div>
               <div>
                <label class="font-bold font-serif">{{__('Password')}}</label>
                <div class="input-group" style="max-width: 320px;">
                    <input type="password" name="password" id="password" class="form-control">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                        <i class="fa fa-eye" id="password-icon"></i>
                    </button>
                </div>

              </div>
                <div>
                <label class="font-bold font-serif">{{__('Address')}}</label>
                <input type="text" name="address" id="address" class="flex w-80 h-3 p-4 rounded"> </br>

                </div>
                 <div>
                <label class="font-bold font-serif">{{__('Phone')}}</label>
                <input type="text" name="phone" id="phone" class="flex w-80 h-3 p-4 rounded"> </br>

                </div>
                <div>
                <label class="font-bold font-serif">{{__('Role')}}</label>
                <select name="role" id="role" class="flex w-80 h-4 p-3 rounded ">
                    <!-- <option value="rab">{{__('Rab')}}</option> -->
                    <!-- <option value="sedo">Sedo</option> -->
                    <!-- <option value="naeb">{{__('NAEB')}}</option> -->
                    <option value="cooperative_manager">{{__('Cooperative Manager')}}</option>
                    <!-- <option value="sector_agronome">{{__('Sector Agronome')}}</option> -->
                    <!-- <option value="district_agronome">{{__('District Agronome')}}</option> -->
                    <option value="self_farmer" >{{__('Self Farmer')}}</option>

                </select> </br>


            </div>

               <div>
                <label class="font-bold font-serif text-xl">{{__('Gender')}}</label>

                    <input class="form-check-input text-2xl" type="radio" name="gender" id="gender" value="male">{{__('Male')}}
                    <input class="form-check-input text-2xl" type="radio" name="gender" id="gender" value="female">{{__('Female')}}

                </div>
             </div> </br>
                <input type="submit" value="Register" class="btn btn-success text-xl" >


            </form>

    </div>
@stop
