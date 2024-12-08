@component('mail::message')

# Vehicle Release Notice

Hi {{ $name }},

{{ $message }}

{{-- Render $additionalMessage with HTML or convert newlines to <br> --}}
@if(isset($additionalMessage))
{!! nl2br(e($additionalMessage)) !!}
@endif

Thank you for using our app!

Best regards,  
{{ config('app.name') }}

@endcomponent
