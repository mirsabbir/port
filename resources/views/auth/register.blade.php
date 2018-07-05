@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">{{ __('Register') }}</div>
                    
                    <!-- Google recaptcha failed -->
                    @if(session()->has('google'))
                        <p class="alert alert-danger">{{session('google')}}</p>
                    @endif
                    <!-- Google recaptcha failed -->
                
                <!-- card -->

                 <!-- show as desabled email field  -->
                 <div class="form-group row">
                    <div>
                        <p class="alert alert-success">Verified Email -- {{session('email')}}</p>
                    </div>
                </div>
                <form action="register/regenerate" method="POST">
                    @csrf
                    <input class="btn btn-primary" type="submit" value="Change Email address">
                </form>


                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf
                       
                        
                        <!-- Name field -->
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

                        

                        <!-- password field -->
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

                        <!-- confirm password field -->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <!-- displaying all errors (its just checking) -->
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                        
                       <!-- accept terms and condition field -->
                        <div class="form-group row">
                            <input type="checkbox" name="terms">&nbsp accept all terms and conditions
                        </div>
                        
                        
                        <!-- google recaptcha field -->
                        <div class="g-recaptcha" data-sitekey="6Ld8P2IUAAAAAAC6eKUkD096nsU6slBFnsv2AeDd"></div>
                        
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


@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
@endpush

@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush