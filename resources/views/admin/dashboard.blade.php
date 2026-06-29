@extends('admin.layouts.app')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="mb-4 col-lg-12 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome, {{ Auth::user()->first_name ?? Auth::user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    @if(Auth::user()->role === 'super_admin')
                                        You have successfully logged into your Super Admin Dashboard. Manage vendors, platform-wide configurations, system statistics, and settings from one beautiful workspace.
                                    @else
                                        You have successfully logged into your Admin Dashboard. Manage fleet operations, bookings, and settings from one beautiful workspace.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-center col-sm-5 text-sm-left">
                            <div class="px-0 pb-0 card-body px-md-4">
                                <img src="{{ asset('assets/admin/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
