@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle'    => 'Vehicle Group / Acriss Code',
    'pageSubtitle' => 'Manage vehicle categories by Acriss classification codes.',
    'actionLabel'  => 'Add Group',
    'columns'      => ['Group Name', 'Acriss Code', 'Description', 'Vehicles Count', 'Status'],
    'rows'         => collect($items)->map(fn($i) => [
        'name'           => $i['name'],
        'code'           => $i['code'],
        'description'    => $i['description'],
        'vehicles_count' => $i['vehicles_count'],
        'status'         => $i['status'],
    ])->all(),
])
@endsection
