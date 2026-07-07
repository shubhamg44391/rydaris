@extends('user.layouts.app')

@section('main-content')
<div class="booking-coverage-page" style="padding: 30px; min-height: 100vh;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        
        <div id="step-confirmed-content" class="print-container" style="animation: fadeIn 0.4s ease forwards; width: 100%;">
            <div class="mb-5 d-flex flex-column align-items-center text-center" style="width: 100%;">
                <div style="width: 70px; height: 70px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);">
                    <svg viewBox="0 0 24 24" width="35" height="35" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h2 class="print-text-dark" style="color: #f8fafc; font-weight: 800; font-size: 2.2rem; margin-bottom: 15px; width: 100%; text-align: center;">Booking Confirmed!</h2>
                <p class="print-text-dark" style="color: #94a3b8; font-size: 1.1rem; max-width: 600px; width: 100%; text-align: center;">
                    Hi <span style="color: #fff; font-weight: 600;">{{ request()->input('fname', 'Customer') }}</span>, we've received your booking <strong style="color: var(--brand);">#DCR{{ rand(10000, 99999) }}</strong> and have sent a confirmation email to <span style="color: #fff; font-weight: 600;">{{ request()->input('email', '') }}</span>.
                </p>
            </div>

            <div class="row g-4">
                <!-- Left Details Column -->
                <div class="col-lg-8">
                    
                    <!-- Rental Period -->
                    <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Rental Period</h4>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="d-flex gap-3">
                                        <div style="color: var(--brand); background: rgba(82,234,210,0.1); padding: 10px; border-radius: 8px; height: fit-content;">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </div>
                                        <div>
                                            <h6 style="color: #f8fafc; font-weight: 700; font-size: 0.95rem; margin-bottom: 5px;">Pickup</h6>
                                            <div style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 3px;">{{ $pickupDate ?? 'Today' }} at {{ $pickupTime }} Hrs</div>
                                            <div style="color: #cbd5e1; font-size: 0.85rem;">{{ $pickupLocation ? $pickupLocation->location : 'Selected Location' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-3">
                                        <div style="color: #ef4444; background: rgba(239,68,68,0.1); padding: 10px; border-radius: 8px; height: fit-content;">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </div>
                                        <div>
                                            <h6 style="color: #f8fafc; font-weight: 700; font-size: 0.95rem; margin-bottom: 5px;">Return</h6>
                                            <div style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 3px;">{{ $returnDate ?? '+2 Days' }} at {{ $returnTime }} Hrs</div>
                                            <div style="color: #cbd5e1; font-size: 0.85rem;">{{ $returnLocation ? $returnLocation->location : 'Selected Location' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle & Extras -->
                    <div class="row mb-4 g-4">
                        <div class="col-md-12">
                            <div class="card h-100" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                                <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                                    <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Vehicle Information</h4>
                                </div>
                                <div class="card-body p-4 pt-2 d-flex align-items-center gap-4">
                                    @if($vehicle->image)
                                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="width: 120px; object-fit: contain;">
                                    @endif
                                    <div>
                                        <h5 style="color: #fff; font-weight: 800; margin-bottom: 5px;">{{ $vehicle->name }}</h5>
                                        <div style="color: #94a3b8; font-size: 0.85rem;">{{ $rentalDays }} Days rental</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Personal Information</h4>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row g-3">
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">First Name:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('fname', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Phone:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('phone', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Last Name:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('lname', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">DOB:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('dob', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Email:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('email', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Payment Method:</span>
                                    <strong style="color: var(--brand); font-size: 0.9rem; text-transform: capitalize;">{{ str_replace('_', ' ', request()->input('payment_method', '')) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Actions Column -->
                <div class="col-lg-4">
                    
                    <!-- Actions -->
                    <div class="card mb-4 no-print" style="background: rgba(16, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Booking Actions</h4>
                        </div>
                        <div class="card-body p-4 pt-2 d-flex flex-column gap-3">
                            <button onclick="window.print()" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background: #f97316; color: #fff; font-weight: 700; padding: 12px; border-radius: 8px; border: none;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                Print Confirmation
                            </button>
                            <button onclick="downloadPDF()" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background: rgba(255,255,255,0.1); color: #fff; font-weight: 700; padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2);">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                Download PDF
                            </button>
                            <a href="{{ url('/') }}" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background: #3b82f6; color: #fff; font-weight: 700; padding: 12px; border-radius: 8px; border: none; text-decoration: none;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                Return Home
                            </a>
                        </div>
                    </div>
                    
                    <!-- Needs Help? -->
                    <div class="card no-print" style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 12px; overflow: hidden;">
                        <div class="card-body p-4">
                            <h4 style="color: #60a5fa; font-weight: 700; font-size: 1.1rem; margin-bottom: 15px;">Need Help?</h4>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#ef4444" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span style="color: #94a3b8; font-size: 0.85rem;">Call: +1-800-RYDARIS</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#60a5fa" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span style="color: #94a3b8; font-size: 0.85rem;">Email: support@rydaris.com</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<!-- html2pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadPDF() {
        const element = document.querySelector('.print-container');
        const opt = {
            margin:       1,
            filename:     'Booking_Confirmation.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, backgroundColor: '#0b1020' },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // Temporarily hide buttons for PDF to make it cleaner
        const noPrintElements = document.querySelectorAll('.no-print');
        noPrintElements.forEach(el => el.style.display = 'none');
        
        html2pdf().set(opt).from(element).save().then(() => {
            // Restore buttons
            noPrintElements.forEach(el => el.style.display = 'block');
        });
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media print {
        body { background: #ffffff !important; }
        body * { visibility: hidden; }
        .print-container, .print-container * { visibility: visible; }
        .print-container { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 20px; color: #000 !important; background: #fff !important; }
        .no-print { display: none !important; }
        .print-text-dark { color: #000 !important; }
        .card { background: #fff !important; border: 1px solid #ccc !important; box-shadow: none !important; color: #000 !important; }
        .card-header, .card-body, strong, h4, h5, h6, span, div { color: #000 !important; }
        svg { stroke: #000 !important; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>
@endsection
