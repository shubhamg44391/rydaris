@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle'   => 'Branch List',
    'pageSubtitle' => 'Manage all your rental branches and pickup locations.',
    'actionLabel' => 'Add Branch',
    'columns'     => ['Branch Name', 'Status' , Action ],
    'rows'        => collect($items)->map(fn($i) => [
        'name'   => $i['name'],
       
        'status' => $i['status'],
        'action' => $i['action'],
    ])->all(),
])
@endsection
