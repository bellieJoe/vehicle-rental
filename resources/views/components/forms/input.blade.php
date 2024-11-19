@props([
    'name', 
    "label" => "",
    "type" => "text",
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

<input 
    class="form-control{{ $type == 'file' ? '-file' : '' }}"
    id="{{ $name }}" 
    type="{{ $type }}"
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    value="{{ old($name, $value) }}"
    {{ $required ? 'required' : '' }} 
    accept="{{$accept}}"
    {{ $disabled ? 'disabled' : '' }} 
    {{ $readonly ? 'readonly' : '' }}
/>

@error($name, $errorBag)
    <span class="text-danger">{{ $message }}</span>
@enderror
