@if (session('message'))    
    <x-alert type="info" message="{{ session('message') }}" />    
@endif

@if (session('success'))    
    <x-alert type="success" message="{{ session('success') }}" />    
@endif

@if (session('error'))    
    <x-alert type="danger" message="{{ session('error') }}" />    
@endif
