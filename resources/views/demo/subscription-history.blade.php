@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Subscription History',
    'pageSubtitle' => 'Your past billing cycles.',
    'columns' => ['Plan', 'Period', 'Amount', 'Status', 'Paid On'],
    'rows' => collect($items)->map(fn ($e) => [
        'plan' => $e['plan'],
        'period' => $e['period'],
        'amount' => $e['amount'],
        'status' => $e['status'],
        'paid' => $e['paid'],
    ])->all(),
])
@endsection
