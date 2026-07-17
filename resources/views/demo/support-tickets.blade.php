@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Support Tickets',
    'pageSubtitle' => 'Your support ticket queue.',
    'actionLabel' => 'New Ticket',
    'actionRoute' => route('demo.support-tickets.create'),
    'columns' => ['Ticket ID', 'Subject', 'Priority', 'Status', 'Date'],
    'rows' => collect($items)->map(fn ($e) => [
        'id' => $e['id'],
        'subject' => $e['subject'],
        'priority' => $e['priority'],
        'status' => $e['status'],
        'date' => $e['date'],
    ])->all(),
])
@endsection
