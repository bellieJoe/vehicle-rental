@extends('main.layouts.master')
@section('content')

    @php
        $yearFilter = [];
        for ($i = date('Y'); $i >= 2024; $i--) {
            array_push($yearFilter, $i);
        }
        $monthFilter = [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ];
    @endphp

    <x-alerts></x-alerts>
    {{ $slot }}

    
@endsection