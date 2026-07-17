@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add New Rule',
    'backRoute' => route('demo.rules'),
    'cols' => 2,
    'fields' => [
        ['name' => 'min_age', 'label' => 'Min Age', 'type' => 'number', 'required' => true, 'placeholder' => 'e.g. 18'],
        ['name' => 'max_age', 'label' => 'Max Age', 'type' => 'number', 'required' => true, 'placeholder' => 'e.g. 25'],
        ['name' => 'underage_charge', 'label' => 'Charges', 'type' => 'number', 'required' => true, 'placeholder' => 'e.g. 10.00'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['Active', 'Inactive']],
    ],
])
@endsection
