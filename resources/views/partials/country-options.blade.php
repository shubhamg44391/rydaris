@php
    $selectedCode = $selected ?? old('country_code');
@endphp
<option value="" style="background: #0f172a; color: #ffffff;">Select</option>
@foreach(config('countries') as $code => $label)
    <option value="{{ $code }}" {{ $selectedCode == $code ? 'selected' : '' }} style="background: #0f172a; color: #ffffff;">{{ $label }}</option>
@endforeach
