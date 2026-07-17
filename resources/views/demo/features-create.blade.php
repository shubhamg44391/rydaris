@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add Feature',
    'backRoute' => route('demo.features'),
    'fields' => [
        ['name' => 'title', 'label' => 'Feature Title', 'required' => true, 'full' => true, 'placeholder' => 'e.g. Unlimited Kilometers'],
    ],
])
@endsection
