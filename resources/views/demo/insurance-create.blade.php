@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add New Insurance',
    'backRoute' => route('demo.insurance'),
    'cols' => 3,
    'fields' => [
        ['name' => 'name', 'label' => 'Insurance Name', 'required' => true, 'placeholder' => 'Enter insurance name'],
        ['name' => 'price', 'label' => 'Online Pay Price', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Online Pay Price'],
        ['name' => 'arrival_price', 'label' => 'Arrival Pay Price', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Arrival Price'],
        ['name' => 'icon_class', 'label' => 'Icon Class', 'type' => 'select', 'required' => true, 'options' => ['Full Insurance', 'Basic Insurance', 'Roadside Assistance', 'Collision Coverage', 'Personal Injury', 'Theft Protection', 'Breakdown Coverage']],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true, 'options' => ['Active', 'Inactive']],
        ['name' => 'refunded_amount', 'label' => 'Refundable Deposit Amount', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Refundable Amount'],
        ['name' => 'excess_amount', 'label' => 'Excess Amount', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Excess Amount'],
        ['name' => 'group_ids', 'label' => 'Group Type', 'type' => 'select', 'options' => ['Economy', 'Compact', 'SUV', 'Luxury', 'Van']],
    ],
])
@endsection
