@props([
    'name', 
    "label" => "",
    "value" => "", 
    "placeholder" => "", 
    "required" => false,
    "disabled" => false,
    "readonly" => false,
    "errorBag" => "default"
])



<label for="{{ $name }}">
    @if ($required)
        <span class="tw-text-red-500">*</span>
    @endif
    {{ $label }}
</label>

@error($name, $errorBag)
    <span class="text-danger">{{ $message }}</span>
@enderror

<textarea 
    id="{{ $name }}" 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ $readonly ? 'readonly' : '' }}
>{{ old($name, $value) }}</textarea>



<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

<script >
    $(document).ready(function() {
        ClassicEditor.create(document.querySelector('#{{ $name }}')).catch(error => {
            console.error(error);
        });
    })
</script>