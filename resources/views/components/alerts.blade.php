@if (session('message'))    
    <x-alert type="info" message="{{ session('message') }}" />    
@endif

@if (session('success'))    
    <x-alert type="success" message="{{ session('success') }}" />    
@endif

@if (session('error'))    
    <x-alert type="danger" message="{{ session('error') }}" />    
@endif

@if ($errors->has('error')) 
    @foreach ($errors->get('error') as $message)
        <x-alert type="danger" message="{!! $message !!}" />    
    @endforeach 
@endif

@error('others')
    <x-alert type="danger" message="{{ $message }}" />
@enderror
