@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Rules',
    'pageSubtitle' => 'Rental policies shown to customers.',
    'actionLabel' => 'Add New Rule',
    'actionRoute' => route('demo.rules.create'),
    'columns' => ['Title', 'Detail', 'Status'],
    'rows' => collect($items)->map(fn ($e) => [
        'title' => $e['title'],
        'detail' => $e['detail'],
        'status' => $e['status'],
    ])->all(),
])
@endsection
