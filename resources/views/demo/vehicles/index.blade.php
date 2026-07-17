@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Vehicle List',
    'pageSubtitle' => 'Your fleet inventory.',
    'actionLabel' => 'Add Vehicle',
    'actionRoute' => route('demo.vehicles.create'),
    'columns' => ['Vehicle', 'Group', 'Plate', 'Year', 'Fuel', 'Seats', 'Status'],
    'rows' => collect($items)->map(fn ($v) => [
        'name' => $v['name'],
        'group' => $v['group'],
        'plate' => $v['plate'],
        'year' => $v['year'],
        'fuel' => $v['fuel'],
        'seats' => $v['seats'],
        'status' => $v['status'],
    ])->all(),
])
@endsection
