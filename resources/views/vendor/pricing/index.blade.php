@extends('admin.layouts.app')

@section('main-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4" style="color: #f8fafc;">
        <span style="color: #aab7cb; font-weight: 300;">Pricing /</span> Current Packages
    </h4>

    <div class="row mb-5">
        @forelse ($packages as $pkg)
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="background: {{ $pkg->is_featured ? 'rgba(82, 234, 210, 0.05)' : 'rgba(255, 255, 255, 0.02)' }}; border: 1px solid {{ $pkg->is_featured ? 'var(--brand, #52ead2)' : 'rgba(255, 255, 255, 0.05)' }}; border-radius: var(--radius); box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-body d-flex flex-column" style="padding: 30px;">
                    @if($pkg->eyebrow)
                        <div class="text-uppercase mb-2 small fw-semibold" style="color: var(--brand, #52ead2); letter-spacing: 1px;">{{ $pkg->eyebrow }}</div>
                    @endif
                    
                    <h3 class="card-title mb-3" style="color: #f8fafc; font-weight: 700;">{{ $pkg->name }}</h3>
                    <p class="card-text" style="color: #aab7cb; min-height: 48px; font-size: 0.95rem;">{{ $pkg->description }}</p>
                    
                    <div class="my-4">
                        <span class="display-5 fw-bold" style="color: #f8fafc; font-size: 2.5rem;">{{ $pkg->price }}</span>
                        @if(strtolower($pkg->price) !== 'custom')
                            <span style="color: #aab7cb;">/{{ $pkg->billing_period }}</span>
                        @endif
                    </div>
                    
                    @if(!is_null($pkg->no_of_users) || !is_null($pkg->no_of_coupons) || !is_null($pkg->no_of_vehicles) || !is_null($pkg->no_of_groups))
                    <ul class="list-unstyled mb-4" style="color: #e2e8f0;">
                        @if(!is_null($pkg->no_of_users))
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_users > 0 ? $pkg->no_of_users . ' Users Included' : 'Unlimited Users' }}
                            </li>
                        @endif
                        @if(!is_null($pkg->no_of_groups))
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_groups > 0 ? $pkg->no_of_groups . ' Groups Included' : 'Unlimited Groups' }}
                            </li>
                        @endif
                        @if(!is_null($pkg->no_of_vehicles))
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_vehicles > 0 ? $pkg->no_of_vehicles . ' Vehicles Included' : 'Unlimited Vehicles' }}
                            </li>
                        @endif
                        @if(!is_null($pkg->no_of_coupons))
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_coupons > 0 ? $pkg->no_of_coupons . ' Coupons Included' : 'Unlimited Coupons' }}
                            </li>
                        @endif
                    </ul>
                    @endif

                    <div class="mt-auto pt-3">
                        @if(strtolower($pkg->price) === 'custom')
                            <a href="{{ route('contact') }}" class="btn w-100" style="padding: 12px; font-weight: 600; border-radius: var(--radius); {{ $pkg->is_featured ? 'background: linear-gradient(135deg, var(--brand, #52ead2), #2bc2a8); color: #050711; border: none;' : 'background: transparent; color: var(--brand, #52ead2); border: 1px solid var(--brand, #52ead2);' }}">
                                {{ $pkg->button_text ?? 'Contact Us' }}
                            </a>
                        @else
                            @php
                                $activeSub = auth()->user()->activeSubscription;
                                $isActive = $activeSub && $activeSub->package_id === $pkg->id;
                            @endphp
                            @if($isActive)
                                <button type="button" class="btn w-100" disabled style="padding: 12px; font-weight: 600; border-radius: var(--radius); background: rgba(255,255,255,0.1); color: #aab7cb; border: 1px solid rgba(255,255,255,0.2);">
                                    Current Package
                                </button>
                            @else
                                <form action="{{ route('vendor.subscribe', $pkg->id) }}" method="POST" class="m-0 p-0 w-100">
                                    @csrf
                                    <button type="submit" class="btn w-100" style="padding: 12px; font-weight: 600; border-radius: var(--radius); {{ $pkg->is_featured ? 'background: linear-gradient(135deg, var(--brand, #52ead2), #2bc2a8); color: #050711; border: none;' : 'background: transparent; color: var(--brand, #52ead2); border: 1px solid var(--brand, #52ead2);' }}">
                                        {{ $pkg->button_text ?? 'Subscribe' }}
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center" style="color: #aab7cb; padding: 40px; background: rgba(255,255,255,0.02); border-radius: var(--radius);">
            <p class="mb-0">No pricing plans available at the moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
