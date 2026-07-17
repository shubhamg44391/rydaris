@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Add Location',
    'backRoute' => route('demo.locations'),
    'cols' => 3,
    'fields' => [
        ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'required' => true, 'options' => ['Select Type', 'Airport', 'City Center', 'Railway Station', 'Hotel', 'Office']],
        ['name' => 'location', 'label' => 'Location', 'required' => true, 'placeholder' => 'Location'],
        ['name' => 'price', 'label' => 'Price', 'type' => 'number', 'required' => true, 'placeholder' => 'Price'],
        ['name' => 'map_type', 'label' => 'Map Type', 'type' => 'select', 'options' => ['Coordinates', 'Embedded Map (iframe)']],
        ['name' => 'latitude', 'label' => 'Latitude', 'placeholder' => 'e.g. 28.6139'],
        ['name' => 'longitude', 'label' => 'Longitude', 'placeholder' => 'e.g. 77.2090'],
        ['name' => 'map_embed', 'label' => 'Map Embed Code (iframe)', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Paste your Google Maps embed iframe code here...'],
    ],
])
@endsection
