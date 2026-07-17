@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Extras List',
    'pageSubtitle' => 'Add-ons customers can book with a rental.',
    'actionLabel' => 'Add New Extra',
    'actionRoute' => route('demo.extras.create'),
    'columns' => ['Name', 'Type', 'Price', 'Status'],
    'rows' => collect($items)->map(fn ($e) => [
        'name' => $e['name'],
        'type' => $e['type'],
        'price' => $e['price'],
        'status' => $e['status'],
    ])->all(),
])
@endsection
