<div class="input-group">
    <label for="{{ $field }}">
        {{ $label }}
    </label>
    <input 
        class="" 
        name="{{ $field }}" 
        id="{{ $field }}" 
        type="text" 
        placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
        value="{{ old($field) }}"
        {{ isset($required) ? 'required' : '' }}>
</div>