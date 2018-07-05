@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Enter your E-mail address') }}</div>

                <div class="card-body" >
                    
                    <form action="" method="get">
                    @csrf
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
                        
                        <input type="submit" class="btn btn-primary" value="Verify">
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
