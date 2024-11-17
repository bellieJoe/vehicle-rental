
@component('mail::message')

# Organization Registered 

Dear {{ $user->name }},

Your organization {{ $organisation->org_name }} has been registered successfully.

To use the app use the password below as your default password. You can change your password at any time in your profile settings.

<x-mail::panel>
    {{ $password }}
</x-mail::panel>

<strong>Important:</strong> Please do not share your password with anyone for your security.


Best regards,

{{ config('app.name') }}
@endcomponent
