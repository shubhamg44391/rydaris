@extends('demo.layout')

@section('content')
@include('demo.partials.list-page', [
    'pageTitle' => 'Coupons',
    'pageSubtitle' => 'Promo codes for the checkout flow.',
    'actionLabel' => 'Add Coupon',
    'actionRoute' => route('demo.coupons.create'),
    'columns' => ['Code', 'Discount', 'Valid Until', 'Uses', 'Status'],
    'rows' => collect($items)->map(fn ($e) => [
        'code' => $e['code'],
        'discount' => $e['discount'],
        'valid' => $e['valid'],
        'uses' => $e['uses'],
        'status' => $e['status'],
    ])->all(),
])
@endsection
