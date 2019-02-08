@extends('layouts.login')
@section('title')
Login
@endsection
@section('content')

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <h1>{{ __('Login') }} Form</h1>
                        <div class="form-group row">
                          

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('E-Mail Address') }}">

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
                            <div >
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                         <div>
                                    
                            <button type="submit" class="btn btn-default submit" href="index.html">{{ __('Login') }}</button>
                              @if (Route::has('password.request'))
                                    <a class="reset_pass" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                          </div>




                            <div class="separator">
               <p class="change_link">New to site?
                  <a href="{{url('/')}}/register" class="to_register"><b> Create Account </b></a>
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
