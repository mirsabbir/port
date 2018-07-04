@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Enter verification code') }}</div>

                <div class="card-body" >
                    <div class="form-group row">
                        <div class="col-md-6" style="margin:auto;"><img src="{{asset('images/email.png')}}" alt=""></div>
                    </div>

                    <h4 class="alert alert-success">An email sent to {{session('email')}}</h4>
                    <form action="register" method="GET">
                    <input type="hidden" name="email" value="{{session('email')}}">
                    <input type="submit" class= "btn btn-primary" value ="send code again">
                    </form>
                    <a href="register">try another email</a>
                    @if(session()->has('failed'))
                    <h4 class="alert alert-danger">{{session('failed')}}</h4>
                    @endif

                    <form action="" method="GET">
                    
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Verification code') }}</label>

                        <div class="col-md-6">
                            <input  type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="code" value="{{ old('email') }}" required>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Verify">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
