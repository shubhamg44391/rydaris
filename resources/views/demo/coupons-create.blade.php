@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add Coupon',
    'backRoute' => route('demo.coupons'),
    'cols' => 2,
    'fields' => [
        ['name' => 'type', 'label' => 'Coupon Type', 'type' => 'select', 'required' => true, 'options' => ['Amount Based', 'Percentage Based']],
        ['name' => 'code', 'label' => 'Coupon Name', 'required' => true, 'placeholder' => 'e.g., SAVE50'],
        ['name' => 'discount', 'label' => 'Discount Amount ($)', 'type' => 'number', 'required' => true, 'placeholder' => 'e.g., 50.00'],
        ['name' => 'description', 'label' => 'Coupon Description', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Describe the coupon conditions, terms, and rules...'],
        ['name' => 'valid_from', 'label' => 'From Date', 'type' => 'date'],
        ['name' => 'valid_to', 'label' => 'To Date', 'type' => 'date'],
        ['name' => 'min_booking_amount', 'label' => 'Minimum Booking Amount ($)', 'type' => 'number', 'placeholder' => 'e.g., 200.00'],
        ['name' => 'availability_count', 'label' => 'Availability Count', 'type' => 'number', 'placeholder' => 'e.g., 25'],
    ],
])
@endsection
