@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add Vehicle',
    'backRoute' => route('demo.vehicles'),
    'cols' => 4,
    'fields' => [
        ['name' => 'name', 'label' => 'Vehicle Name', 'required' => true, 'placeholder' => 'Peugeot 107'],
        ['name' => 'model', 'label' => 'Model', 'required' => true, 'placeholder' => 'Model'],
        ['name' => 'seats', 'label' => 'Seats', 'type' => 'number', 'required' => true, 'placeholder' => '4'],
        ['name' => 'doors', 'label' => 'Doors', 'type' => 'number', 'required' => true, 'placeholder' => '4'],
        ['name' => 'bags', 'label' => 'Bags', 'type' => 'number', 'required' => true, 'placeholder' => '1'],
        ['name' => 'group_id', 'label' => 'Vehicle Type (Group)', 'type' => 'select', 'options' => ['-- Select Group --', 'Economy', 'Compact', 'SUV', 'Luxury', 'Van']],
        ['name' => 'status', 'label' => 'Vehicle Status', 'type' => 'select', 'required' => true, 'options' => ['Active', 'Inactive']],
        ['name' => 'image', 'label' => 'Vehicle Image', 'type' => 'file'],
        ['name' => 'gear_system', 'label' => 'Gear system', 'type' => 'select', 'required' => true, 'options' => ['manual', 'automatic']],
        ['name' => 'passengers', 'label' => 'Passengers', 'type' => 'number', 'required' => true, 'placeholder' => '4'],
        ['name' => 'wheel_drive', 'label' => 'Wheel drive', 'type' => 'select', 'required' => true, 'options' => ['FWD', 'RWD', 'AWD']],
        ['name' => 'code', 'label' => 'Vehicle Code', 'required' => true, 'placeholder' => 'Vehicle Code'],
        ['name' => 'stock', 'label' => 'Stock', 'type' => 'number', 'required' => true, 'placeholder' => '1'],
        ['name' => 'features', 'label' => 'Vehicle Features', 'full' => true, 'placeholder' => 'Enter feature'],
        ['name' => 'terms', 'label' => 'Terms & Conditions', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Enter terms & conditions...'],
    ],
])
@endsection
