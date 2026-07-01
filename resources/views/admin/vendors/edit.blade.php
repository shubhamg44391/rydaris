@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 style="font-size: 1.4rem; color: #111827; margin: 0;">Edit Vendor Profile</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.vendors.update', $vendor->id) }}">
                @csrf
                @method('PUT')

                <!-- First Name -->
                <div class="mb-4">
                    <label for="first_name" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">First Name</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
                        value="{{ old('first_name', $vendor->first_name) }}" required placeholder="Enter first name" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $vendor->email) }}" required placeholder="name@company.com" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contact Details -->
                <div class="mb-4">
                    <label style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Contact Details</label>
                    <div class="input-group" style="display: flex; gap: 8px;">
                        <select name="country_code" class="form-select @error('country_code') is-invalid @enderror" style="max-width: 130px; border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; background-color: #ffffff;" required>
                            <option value="+93" {{ old('country_code', $vendor->country_code) === '+93' ? 'selected' : '' }}>+93 (AF)</option>
                            <option value="+355" {{ old('country_code', $vendor->country_code) === '+355' ? 'selected' : '' }}>+355 (AL)</option>
                            <option value="+213" {{ old('country_code', $vendor->country_code) === '+213' ? 'selected' : '' }}>+213 (DZ)</option>
                            <option value="+376" {{ old('country_code', $vendor->country_code) === '+376' ? 'selected' : '' }}>+376 (AD)</option>
                            <option value="+244" {{ old('country_code', $vendor->country_code) === '+244' ? 'selected' : '' }}>+244 (AO)</option>
                            <option value="+54" {{ old('country_code', $vendor->vendor_code) === '+54' || old('country_code', $vendor->country_code) === '+54' ? 'selected' : '' }}>+54 (AR)</option>
                            <option value="+374" {{ old('country_code', $vendor->country_code) === '+374' ? 'selected' : '' }}>+374 (AM)</option>
                            <option value="+61" {{ old('country_code', $vendor->country_code) === '+61' ? 'selected' : '' }}>+61 (AU)</option>
                            <option value="+43" {{ old('country_code', $vendor->country_code) === '+43' ? 'selected' : '' }}>+43 (AT)</option>
                            <option value="+994" {{ old('country_code', $vendor->country_code) === '+994' ? 'selected' : '' }}>+994 (AZ)</option>
                            <option value="+1" {{ old('country_code', $vendor->country_code) === '+1' ? 'selected' : '' }}>+1 (BS)</option>
                            <option value="+973" {{ old('country_code', $vendor->country_code) === '+973' ? 'selected' : '' }}>+973 (BH)</option>
                            <option value="+880" {{ old('country_code', $vendor->country_code) === '+880' ? 'selected' : '' }}>+880 (BD)</option>
                            <option value="+375" {{ old('country_code', $vendor->country_code) === '+375' ? 'selected' : '' }}>+375 (BY)</option>
                            <option value="+32" {{ old('country_code', $vendor->country_code) === '+32' ? 'selected' : '' }}>+32 (BE)</option>
                            <option value="+591" {{ old('country_code', $vendor->country_code) === '+591' ? 'selected' : '' }}>+591 (BO)</option>
                            <option value="+387" {{ old('country_code', $vendor->country_code) === '+387' ? 'selected' : '' }}>+387 (BA)</option>
                            <option value="+55" {{ old('country_code', $vendor->country_code) === '+55' ? 'selected' : '' }}>+55 (BR)</option>
                            <option value="+673" {{ old('country_code', $vendor->country_code) === '+673' ? 'selected' : '' }}>+673 (BN)</option>
                            <option value="+359" {{ old('country_code', $vendor->country_code) === '+359' ? 'selected' : '' }}>+359 (BG)</option>
                            <option value="+855" {{ old('country_code', $vendor->country_code) === '+855' ? 'selected' : '' }}>+855 (KH)</option>
                            <option value="+237" {{ old('country_code', $vendor->country_code) === '+237' ? 'selected' : '' }}>+237 (CM)</option>
                            <option value="+1" {{ old('country_code', $vendor->country_code) === '+1' ? 'selected' : '' }}>+1 (CA)</option>
                            <option value="+56" {{ old('country_code', $vendor->country_code) === '+56' ? 'selected' : '' }}>+56 (CL)</option>
                            <option value="+86" {{ old('country_code', $vendor->country_code) === '+86' ? 'selected' : '' }}>+86 (CN)</option>
                            <option value="+57" {{ old('country_code', $vendor->country_code) === '+57' ? 'selected' : '' }}>+57 (CO)</option>
                            <option value="+506" {{ old('country_code', $vendor->country_code) === '+506' ? 'selected' : '' }}>+506 (CR)</option>
                            <option value="+385" {{ old('country_code', $vendor->country_code) === '+385' ? 'selected' : '' }}>+385 (HR)</option>
                            <option value="+53" {{ old('country_code', $vendor->country_code) === '+53' ? 'selected' : '' }}>+53 (CU)</option>
                            <option value="+357" {{ old('country_code', $vendor->country_code) === '+357' ? 'selected' : '' }}>+357 (CY)</option>
                            <option value="+420" {{ old('country_code', $vendor->country_code) === '+420' ? 'selected' : '' }}>+420 (CZ)</option>
                            <option value="+45" {{ old('country_code', $vendor->country_code) === '+45' ? 'selected' : '' }}>+45 (DK)</option>
                            <option value="+593" {{ old('country_code', $vendor->country_code) === '+593' ? 'selected' : '' }}>+593 (EC)</option>
                            <option value="+20" {{ old('country_code', $vendor->country_code) === '+20' ? 'selected' : '' }}>+20 (EG)</option>
                            <option value="+503" {{ old('country_code', $vendor->country_code) === '+503' ? 'selected' : '' }}>+503 (SV)</option>
                            <option value="+372" {{ old('country_code', $vendor->country_code) === '+372' ? 'selected' : '' }}>+372 (EE)</option>
                            <option value="+251" {{ old('country_code', $vendor->country_code) === '+251' ? 'selected' : '' }}>+251 (ET)</option>
                            <option value="+358" {{ old('country_code', $vendor->country_code) === '+358' ? 'selected' : '' }}>+358 (FI)</option>
                            <option value="+33" {{ old('country_code', $vendor->country_code) === '+33' ? 'selected' : '' }}>+33 (FR)</option>
                            <option value="+995" {{ old('country_code', $vendor->country_code) === '+995' ? 'selected' : '' }}>+995 (GE)</option>
                            <option value="+49" {{ old('country_code', $vendor->country_code) === '+49' ? 'selected' : '' }}>+49 (DE)</option>
                            <option value="+233" {{ old('country_code', $vendor->country_code) === '+233' ? 'selected' : '' }}>+233 (GH)</option>
                            <option value="+30" {{ old('country_code', $vendor->country_code) === '+30' ? 'selected' : '' }}>+30 (GR)</option>
                            <option value="+502" {{ old('country_code', $vendor->country_code) === '+502' ? 'selected' : '' }}>+502 (GT)</option>
                            <option value="+504" {{ old('country_code', $vendor->country_code) === '+504' ? 'selected' : '' }}>+504 (HN)</option>
                            <option value="+852" {{ old('country_code', $vendor->country_code) === '+852' ? 'selected' : '' }}>+852 (HK)</option>
                            <option value="+36" {{ old('country_code', $vendor->country_code) === '+36' ? 'selected' : '' }}>+36 (HU)</option>
                            <option value="+354" {{ old('country_code', $vendor->country_code) === '+354' ? 'selected' : '' }}>+354 (IS)</option>
                            <option value="+91" {{ old('country_code', $vendor->country_code) === '+91' ? 'selected' : '' }}>+91 (IN)</option>
                            <option value="+62" {{ old('country_code', $vendor->country_code) === '+62' ? 'selected' : '' }}>+62 (ID)</option>
                            <option value="+98" {{ old('country_code', $vendor->country_code) === '+98' ? 'selected' : '' }}>+98 (IR)</option>
                            <option value="+964" {{ old('country_code', $vendor->country_code) === '+964' ? 'selected' : '' }}>+964 (IQ)</option>
                            <option value="+353" {{ old('country_code', $vendor->country_code) === '+353' ? 'selected' : '' }}>+353 (IE)</option>
                            <option value="+972" {{ old('country_code', $vendor->country_code) === '+972' ? 'selected' : '' }}>+972 (IL)</option>
                            <option value="+39" {{ old('country_code', $vendor->country_code) === '+39' ? 'selected' : '' }}>+39 (IT)</option>
                            <option value="+1" {{ old('country_code', $vendor->country_code) === '+1' ? 'selected' : '' }}>+1 (JM)</option>
                            <option value="+81" {{ old('country_code', $vendor->country_code) === '+81' ? 'selected' : '' }}>+81 (JP)</option>
                            <option value="+962" {{ old('country_code', $vendor->country_code) === '+962' ? 'selected' : '' }}>+962 (JO)</option>
                            <option value="+7" {{ old('country_code', $vendor->country_code) === '+7' ? 'selected' : '' }}>+7 (KZ)</option>
                            <option value="+254" {{ old('country_code', $vendor->country_code) === '+254' ? 'selected' : '' }}>+254 (KE)</option>
                            <option value="+965" {{ old('country_code', $vendor->country_code) === '+965' ? 'selected' : '' }}>+965 (KW)</option>
                            <option value="+371" {{ old('country_code', $vendor->country_code) === '+371' ? 'selected' : '' }}>+371 (LV)</option>
                            <option value="+961" {{ old('country_code', $vendor->country_code) === '+961' ? 'selected' : '' }}>+961 (LB)</option>
                            <option value="+218" {{ old('country_code', $vendor->country_code) === '+218' ? 'selected' : '' }}>+218 (LY)</option>
                            <option value="+370" {{ old('country_code', $vendor->country_code) === '+370' ? 'selected' : '' }}>+370 (LT)</option>
                            <option value="+352" {{ old('country_code', $vendor->country_code) === '+352' ? 'selected' : '' }}>+352 (LU)</option>
                            <option value="+853" {{ old('country_code', $vendor->country_code) === '+853' ? 'selected' : '' }}>+853 (MO)</option>
                            <option value="+389" {{ old('country_code', $vendor->country_code) === '+389' ? 'selected' : '' }}>+389 (MK)</option>
                            <option value="+60" {{ old('country_code', $vendor->country_code) === '+60' ? 'selected' : '' }}>+60 (MY)</option>
                            <option value="+960" {{ old('country_code', $vendor->country_code) === '+960' ? 'selected' : '' }}>+960 (MV)</option>
                            <option value="+356" {{ old('country_code', $vendor->country_code) === '+356' ? 'selected' : '' }}>+356 (MT)</option>
                            <option value="+52" {{ old('country_code', $vendor->country_code) === '+52' ? 'selected' : '' }}>+52 (MX)</option>
                            <option value="+373" {{ old('country_code', $vendor->country_code) === '+373' ? 'selected' : '' }}>+373 (MD)</option>
                            <option value="+377" {{ old('country_code', $vendor->country_code) === '+377' ? 'selected' : '' }}>+377 (MC)</option>
                            <option value="+382" {{ old('country_code', $vendor->country_code) === '+382' ? 'selected' : '' }}>+382 (ME)</option>
                            <option value="+212" {{ old('country_code', $vendor->country_code) === '+212' ? 'selected' : '' }}>+212 (MA)</option>
                            <option value="+95" {{ old('country_code', $vendor->country_code) === '+95' ? 'selected' : '' }}>+95 (MM)</option>
                            <option value="+977" {{ old('country_code', $vendor->country_code) === '+977' ? 'selected' : '' }}>+977 (NP)</option>
                            <option value="+31" {{ old('country_code', $vendor->country_code) === '+31' ? 'selected' : '' }}>+31 (NL)</option>
                            <option value="+64" {{ old('country_code', $vendor->country_code) === '+64' ? 'selected' : '' }}>+64 (NZ)</option>
                            <option value="+234" {{ old('country_code', $vendor->country_code) === '+234' ? 'selected' : '' }}>+234 (NG)</option>
                            <option value="+47" {{ old('country_code', $vendor->country_code) === '+47' ? 'selected' : '' }}>+47 (NO)</option>
                            <option value="+968" {{ old('country_code', $vendor->country_code) === '+968' ? 'selected' : '' }}>+968 (OM)</option>
                            <option value="+92" {{ old('country_code', $vendor->country_code) === '+92' ? 'selected' : '' }}>+92 (PK)</option>
                            <option value="+507" {{ old('country_code', $vendor->country_code) === '+507' ? 'selected' : '' }}>+507 (PA)</option>
                            <option value="+595" {{ old('country_code', $vendor->country_code) === '+595' ? 'selected' : '' }}>+595 (PY)</option>
                            <option value="+51" {{ old('country_code', $vendor->country_code) === '+51' ? 'selected' : '' }}>+51 (PE)</option>
                            <option value="+63" {{ old('country_code', $vendor->country_code) === '+63' ? 'selected' : '' }}>+63 (PH)</option>
                            <option value="+48" {{ old('country_code', $vendor->country_code) === '+48' ? 'selected' : '' }}>+48 (PL)</option>
                            <option value="+351" {{ old('country_code', $vendor->country_code) === '+351' ? 'selected' : '' }}>+351 (PT)</option>
                            <option value="+974" {{ old('country_code', $vendor->country_code) === '+974' ? 'selected' : '' }}>+974 (QA)</option>
                            <option value="+40" {{ old('country_code', $vendor->country_code) === '+40' ? 'selected' : '' }}>+40 (RO)</option>
                            <option value="+7" {{ old('country_code', $vendor->country_code) === '+7' ? 'selected' : '' }}>+7 (RU)</option>
                            <option value="+966" {{ old('country_code', $vendor->country_code) === '+966' ? 'selected' : '' }}>+966 (SA)</option>
                            <option value="+221" {{ old('country_code', $vendor->country_code) === '+221' ? 'selected' : '' }}>+221 (SN)</option>
                            <option value="+381" {{ old('country_code', $vendor->country_code) === '+381' ? 'selected' : '' }}>+381 (RS)</option>
                            <option value="+65" {{ old('country_code', $vendor->country_code) === '+65' ? 'selected' : '' }}>+65 (SG)</option>
                            <option value="+421" {{ old('country_code', $vendor->country_code) === '+421' ? 'selected' : '' }}>+421 (SK)</option>
                            <option value="+386" {{ old('country_code', $vendor->country_code) === '+386' ? 'selected' : '' }}>+386 (SI)</option>
                            <option value="+27" {{ old('country_code', $vendor->country_code) === '+27' ? 'selected' : '' }}>+27 (ZA)</option>
                            <option value="+82" {{ old('country_code', $vendor->country_code) === '+82' ? 'selected' : '' }}>+82 (KR)</option>
                            <option value="+34" {{ old('country_code', $vendor->country_code) === '+34' ? 'selected' : '' }}>+34 (ES)</option>
                            <option value="+94" {{ old('country_code', $vendor->country_code) === '+94' ? 'selected' : '' }}>+94 (LK)</option>
                            <option value="+46" {{ old('country_code', $vendor->country_code) === '+46' ? 'selected' : '' }}>+46 (SE)</option>
                            <option value="+41" {{ old('country_code', $vendor->country_code) === '+41' ? 'selected' : '' }}>+41 (CH)</option>
                            <option value="+886" {{ old('country_code', $vendor->country_code) === '+886' ? 'selected' : '' }}>+886 (TW)</option>
                            <option value="+66" {{ old('country_code', $vendor->country_code) === '+66' ? 'selected' : '' }}>+66 (TH)</option>
                            <option value="+216" {{ old('country_code', $vendor->country_code) === '+216' ? 'selected' : '' }}>+216 (TN)</option>
                            <option value="+90" {{ old('country_code', $vendor->country_code) === '+90' ? 'selected' : '' }}>+90 (TR)</option>
                            <option value="+380" {{ old('country_code', $vendor->country_code) === '+380' ? 'selected' : '' }}>+380 (UA)</option>
                            <option value="+971" {{ old('country_code', $vendor->country_code) === '+971' ? 'selected' : '' }}>+971 (AE)</option>
                            <option value="+44" {{ old('country_code', $vendor->country_code) === '+44' ? 'selected' : '' }}>+44 (GB)</option>
                            <option value="+1" {{ old('country_code', $vendor->country_code) === '+1' ? 'selected' : '' }}>+1 (US)</option>
                            <option value="+598" {{ old('country_code', $vendor->country_code) === '+598' ? 'selected' : '' }}>+598 (UY)</option>
                            <option value="+998" {{ old('country_code', $vendor->country_code) === '+998' ? 'selected' : '' }}>+998 (UZ)</option>
                            <option value="+58" {{ old('country_code', $vendor->country_code) === '+58' ? 'selected' : '' }}>+58 (VE)</option>
                            <option value="+84" {{ old('country_code', $vendor->country_code) === '+84' ? 'selected' : '' }}>+84 (VN)</option>
                            <option value="+967" {{ old('country_code', $vendor->country_code) === '+967' ? 'selected' : '' }}>+967 (YE)</option>
                            <option value="+263" {{ old('country_code', $vendor->country_code) === '+263' ? 'selected' : '' }}>+263 (ZW)</option>
                        </select>
                        <input type="tel" id="contact_number" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror"
                            placeholder="Phone number" value="{{ old('contact_number', $vendor->contact_number) }}" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; flex: 1;" required />
                    </div>
                    @error('country_code')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    @error('contact_number')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vendor Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background-color: #ffffff;" required>
                        <option value="active" {{ old('status', $vendor->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $vendor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Save Changes</button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-link text-muted" style="text-decoration: none; font-weight: 800; font-size: 0.9rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
