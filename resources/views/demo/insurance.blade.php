@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Insurance List',
    'pageSubtitle' => 'Coverage options shown during booking checkout.',
    'actionLabel' => 'Add New Insurance',
    'actionRoute' => route('demo.insurance.create'),
    'columns' => ['Name', 'Coverage', 'Price', 'Status'],
    'rows' => collect($items)->map(fn ($e) => [
        'name' => $e['name'],
        'coverage' => $e['coverage'],
        'price' => $e['price'],
        'status' => $e['status'],
    ])->all(),
])
@endsection
