@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add New Extra',
    'backRoute' => route('demo.extras'),
    'cols' => 3,
    'fields' => [
        ['name' => 'name', 'label' => 'Extra Name', 'required' => true, 'placeholder' => 'Enter extra name'],
        ['name' => 'price', 'label' => 'Online Pay Price', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Online Pay Price'],
        ['name' => 'arrival_price', 'label' => 'Arrival Pay Price', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Arrival Price'],
        ['name' => 'icon_class', 'label' => 'Icon Class', 'type' => 'select', 'required' => true, 'options' => ['Additional Driver', 'GPS Navigation System', 'Baby Seat (0-13kg)', 'Child Seat (9-18kg)', 'WiFi', 'Snow Chains', 'Extra Car Seat', 'Fuel Option', 'Parking Pass', 'Roadside Assistance', 'Other']],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true, 'options' => ['Active', 'Inactive']],
        ['name' => 'refunded_amount', 'label' => 'Refundable Deposit Amount', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Refundable Amount'],
        ['name' => 'excess_amount', 'label' => 'Excess Amount', 'type' => 'number', 'required' => true, 'placeholder' => 'Enter Excess Amount'],
        ['name' => 'group_ids', 'label' => 'Group Type', 'type' => 'select', 'options' => ['Economy', 'Compact', 'SUV', 'Luxury', 'Van']],
    ],
])
@endsection
