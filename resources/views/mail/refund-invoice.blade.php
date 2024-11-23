@component('mail::message')

# Refund Invoice

Hi {{ $refund->booking->user->name ?? 'User' }},

Your refund request has been processed and the refund amount of Php {{ number_format($refund->amount, 2) }} has been sent to your Gcash account.

@if ($refund->gcash_transaction_number)
@component('mail::panel')
### GCash Transaction Number:  
**{{ $refund->gcash_transaction_number }}**
@endcomponent
@else
@component('mail::panel')
### GCash Transaction Number:  
_Not Available_
@endcomponent
@endif
    
@endcomponent