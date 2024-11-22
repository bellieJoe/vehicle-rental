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

<!-- Use the `old` helper to populate the textarea -->
<textarea 
    id="{{ $name }}" 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ $readonly ? 'readonly' : '' }}
>{{ old($name, $value) }}</textarea>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        ClassicEditor.create(document.querySelector('#{{ $name }}'))
        .then(editor => {
            // Initialize the editor with the value from `old` or default value
            const defaultValue = {!! json_encode(old($name, $value)) !!};
            editor.setData(defaultValue); // Set the data inside the editor
        })
        .catch(error => {
            console.error(error);
        });
    });
</script>
