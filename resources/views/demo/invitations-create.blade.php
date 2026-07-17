@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'Invite New User',
    'backRoute' => route('demo.invitations'),
    'fields' => [
        ['name' => 'name', 'label' => "Invited Person's Name (Optional)", 'full' => true, 'placeholder' => 'Enter full name (e.g. John Doe)'],
        ['name' => 'email', 'label' => 'Email Address', 'type' => 'email', 'required' => true, 'full' => true, 'placeholder' => 'Enter email address (e.g. john@example.com)'],
    ],
])
@endsection
