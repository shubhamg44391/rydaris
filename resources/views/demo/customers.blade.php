@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Customer List',
    'pageSubtitle' => 'Manage your customers.',
    'actionLabel' => 'Add New Customer',
    'actionRoute' => route('demo.customers.create'),
    'columns' => ['Name', 'Email', 'Phone', 'Branch', 'Status'],
    'rows' => collect($items)->map(fn ($c) => [
        'name' => $c['name'],
        'email' => $c['email'],
        'phone' => $c['phone'],
        'branch' => $c['branch'],
        'status' => $c['status'],
    ])->all(),
])
@endsection
