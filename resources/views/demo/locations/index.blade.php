@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Location List',
    'pageSubtitle' => 'Your pickup / drop-off counters.',
    'actionLabel' => 'Add Location',
    'actionRoute' => route('demo.locations.create'),
    'columns' => ['Name', 'City', 'Address', 'Phone', 'Hours', 'Status'],
    'rows' => collect($items)->map(fn ($l) => [
        'name' => $l['name'],
        'city' => $l['city'],
        'address' => $l['address'],
        'phone' => $l['phone'],
        'hours' => $l['hours'],
        'status' => $l['status'],
    ])->all(),
])
@endsection
