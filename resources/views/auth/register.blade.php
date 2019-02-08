@extends('layouts.login')
@section('title')
Register
@endsection
@section('content')
 <form method="POST" action="{{ route('register') }}">
         @csrf
         <h1>Register</h1>
         <div class="form-group row">
            <div class="col-md-12">
               <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="{{ __('Name') }}">
               @if ($errors->has('name'))
               <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('name') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <div class="form-group row">
           
            <div class="col-md-12">
               <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ __('E-Mail Address') }}">
               @if ($errors->has('email'))
               <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('email') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <div class="form-group row">
         
            <div class="col-md-12">
               <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">
               @if ($errors->has('password'))
               <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('password') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <div class="form-group row">
            
            <div class="col-md-12">
               <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{ __('Confirm Password') }}">
            </div>
         </div>
         <div class="form-group row mb-0">
            <div class="col-md-12 offset-md-4">
               <button type="submit" class="btn btn-dark submit btn-block">
               {{ __('Register') }}
               </button>
            </div>
         </div>

           <div class="separator">
                <p class="change_link">Are you already registered?
                  <a href="{{url('/')}}/login" class="to_register"><b>Create Account<b></a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <img src="{{url('/')}}/panel/logo.png" width="150px">
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
      </form>
@endsection
