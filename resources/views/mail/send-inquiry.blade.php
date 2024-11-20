@component('mail::message')

# {{ $title }}

Hi {{ $name }},

{!! nl2br(e($message)) !!}


Best regards,

{{ config('app.name') }}
    
@endcomponent