@php
    $selectedCode = $selected ?? old('country_code');
@endphp
<option value="">Select</option>
@foreach(config('countries') as $code => $label)
    <option value="{{ $code }}" {{ $selectedCode == $code ? 'selected' : '' }}>{{ $label }}</option>
@endforeach
