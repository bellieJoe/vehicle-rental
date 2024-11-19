@props(['type' => "info", 'message' => ""])
<div class="alert alert-{{$type}} alert-dismissible fade show" role="alert">
    <p>{{ $message }}</p> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>