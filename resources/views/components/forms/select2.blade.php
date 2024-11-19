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
    "queryUrl" => ""
])

<label for="{{ $name }}">
    @if ($required)
        <span class="tw-text-red-500">*</span>
    @endif
    {{ $label }}
</label>

<br>
<select 
class="tw-block form-control tw-full select2"
id="{{ $name }}" 
name="{{ $name }}" 
placeholder="{{ $placeholder }}" 
{{ $required ? 'required' : '' }} 
{{ $disabled ? 'disabled' : '' }} 
{{ $readonly ? 'readonly' : '' }}
>
</select>

@error($name, $errorBag)
    <span class="text-danger">{{ $message }}</span>
@enderror

<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            ajax: {
                url: '{{ $queryUrl }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id, // The value for the option
                                text: item.text // The text to display in the dropdown
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>
