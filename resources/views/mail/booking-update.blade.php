@component('mail::message')

# Booking Update

Hi {{ $toUser->name ?? 'User' }},

{{ $message }}

@component('mail::button', ['url' => $url])
Check Bookings
@endcomponent

Thank you for using our app!

Best regards,
{{ config('app.name') }}

@endcomponent
