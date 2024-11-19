@props([
    "name",
    "label" => "",
    "value" => "",
    "placeholder" => "",
    "placeholder" => "", 
    "required" => false,
    "disabled" => false,
    "readonly" => false,
    "errorBag" => "default",
    "options" => []
])

<label for="{{ $name }}">
    @if ($required)
        <span class="tw-text-red-500">*</span>
    @endif
    {{ $label }}
</label>

<br>
<select 
    class="tw-block form-control tw-full"
    id="{{ $name }}" 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    {{ $required ? 'required' : '' }} 
    {{ $disabled ? 'disabled' : '' }} 
    {{ $readonly ? 'readonly' : '' }}
>
    @if (count($options) > 0)
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" {{ $value == $key ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    @else
        <option value="">{{ $placeholder }}</option>
    @endif
</select>

@error($name, $errorBag)
    <span class="text-danger">{{ $message }}</span>
@enderror


