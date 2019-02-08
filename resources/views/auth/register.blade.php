@extends('layouts.login')

@section('content')
<<<<<<< HEAD
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
=======


<div  id="register " class=" animate form registration_form">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

>>>>>>> 5c9fde7860913948c6941a619f5175e45db3450e
@endsection
