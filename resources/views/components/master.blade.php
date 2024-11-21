@extends('main.layouts.master')
@section('content')
    <x-alerts></x-alerts>
    {{ $slot }}

    
@endsection