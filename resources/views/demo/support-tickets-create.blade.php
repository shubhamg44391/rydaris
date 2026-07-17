@extends('demo.layout')

@section('content')
@include('demo.partials.form-page', [
    'pageTitle' => 'New Ticket',
    'backRoute' => route('demo.support-tickets'),
    'cols' => 2,
    'fields' => [
        ['name' => 'subject', 'label' => 'Subject', 'required' => true, 'full' => true, 'placeholder' => 'Brief summary of your issue'],
        ['name' => 'priority', 'label' => 'Priority', 'type' => 'select', 'required' => true, 'options' => ['Low', 'Medium', 'High']],
        ['name' => 'attachment', 'label' => 'Attachment', 'type' => 'file'],
        ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true, 'full' => true, 'placeholder' => 'Describe your issue in detail...'],
    ],
])
@endsection
