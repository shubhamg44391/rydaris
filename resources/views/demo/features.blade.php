@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Features Mapping',
    'pageSubtitle' => 'Which features map to which vehicle groups.',
    'actionLabel' => 'Add Feature',
    'actionRoute' => route('demo.features.create'),
    'columns' => ['Feature', 'Group(s)', 'Mapped'],
    'rows' => collect($items)->map(fn ($e) => [
        'feature' => $e['feature'],
        'group' => $e['group'],
        'mapped' => $e['mapped'],
    ])->all(),
])
@endsection
