@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@push('styles')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
@endpush

@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush