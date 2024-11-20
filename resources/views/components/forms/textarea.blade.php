@props([
    'name', 
    "label" => "",
    "value" => "", 
    "placeholder" => "", 
    "required" => false,
    "disabled" => false,
    "readonly" => false,
    "errorBag" => "default",
    "accept" => ""
])

<label for="{{ $name }}">
    @if ($required)
        <span class="tw-text-red-500">*</span>
    @endif
    {{ $label }}
</label>

<textarea 
    class="form-control"
    id="{{ $name }}" 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    {{ $required ? 'required' : '' }} 
    accept="{{$accept}}"
    {{ $disabled ? 'disabled' : '' }} 
    {{ $readonly ? 'readonly' : '' }}
>{{ old($name) }}</textarea>

@error($name, $errorBag)
    <span class="text-danger">{{ $message }}</span>
@enderror
