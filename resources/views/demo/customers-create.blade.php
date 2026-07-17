@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add New Customer',
    'backRoute' => route('demo.customers'),
    'cols' => 2,
    'fields' => [
        ['name' => 'first_name', 'label' => 'First Name', 'required' => true, 'placeholder' => 'Enter first name'],
        ['name' => 'last_name', 'label' => 'Last Name', 'required' => true, 'placeholder' => 'Enter last name'],
        ['name' => 'email', 'label' => 'Email Address', 'type' => 'email', 'required' => true, 'full' => true, 'placeholder' => 'customer@example.com'],
        ['name' => 'contact_number', 'label' => 'Contact Number', 'required' => true, 'full' => true, 'placeholder' => 'Phone number'],
        ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'required' => true, 'placeholder' => 'Minimum 8 characters'],
        ['name' => 'password_confirmation', 'label' => 'Confirm Password', 'type' => 'password', 'required' => true, 'placeholder' => 'Confirm password'],
    ],
])
@endsection
