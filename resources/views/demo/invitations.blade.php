@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'User Invitations',
    'pageSubtitle' => 'Manage your team member invitations.',
    'actionLabel' => 'Invite New User',
    'actionRoute' => route('demo.invitations.create'),
    'columns' => ['Email', 'Role', 'Sent On', 'Status'],
    'rows' => collect($items)->map(fn ($i) => [
        'email' => $i['email'],
        'role' => $i['role'],
        'sent' => $i['sent'],
        'status' => $i['status'],
    ])->all(),
])
@endsection
