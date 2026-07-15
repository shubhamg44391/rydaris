@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Create Pricing Package</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.packages.store') }}">
                @csrf

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Name -->
                    <div>
                        <label for="name" class="form-label-custom">Package Name</label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required placeholder="e.g., Launch, Growth, Enterprise" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Eyebrow -->
                    <div>
                        <label for="eyebrow" class="form-label-custom">Eyebrow / Badge Text</label>
                        <input type="text" class="form-control form-input-custom @error('eyebrow') is-invalid @enderror" id="eyebrow" name="eyebrow"
                            value="{{ old('eyebrow') }}" placeholder="e.g., Starter, Most selected, Scale" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('eyebrow')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Billing Period -->
                    <div>
                        <label for="billing_period" class="form-label-custom">Billing Cycle</label>
                        <select id="billing_period" name="billing_period" class="form-select form-input-custom" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; cursor: pointer;">
                            <option value="/ month" {{ old('billing_period', '/ month') === '/ month' ? 'selected' : '' }}>Monthly</option>
                            <option value="/ quarter" {{ old('billing_period') === '/ quarter' ? 'selected' : '' }}>Quarterly</option>
                            <option value="/ year" {{ old('billing_period') === '/ year' ? 'selected' : '' }}>Yearly</option>
                            <option value="" {{ old('billing_period') === '' ? 'selected' : '' }}>Custom</option>
                        </select>
                        @error('billing_period')
                            <div class="invalid-feedback d-block" style="margin-top: 8px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="form-label-custom">Price</label>
                        <input type="text" class="form-control form-input-custom @error('price') is-invalid @enderror" id="price" name="price"
                            value="{{ old('price') }}" required placeholder="e.g., $79, $189, Custom" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        <div style="margin-top: 8px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.88rem; color: var(--muted, #a8b3c5);">
                                <input type="checkbox" id="is_free_pkg" style="width: 16px; height: 16px; accent-color: var(--brand, #52ead2);" {{ old('price') === 'Free' ? 'checked' : '' }} />
                                Is Free Package
                            </label>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Description</label>
                    <textarea class="form-control form-input-custom @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="Plan description / details" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="form-label-custom">Button Text</label>
                        <input type="text" class="form-control form-input-custom @error('button_text') is-invalid @enderror" id="button_text" name="button_text"
                            value="{{ old('button_text', 'Book Demo') }}" required placeholder="e.g., Start Launch, Talk to Sales" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('button_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="form-label-custom">Display Order</label>
                        <input type="number" class="form-control form-input-custom @error('order') is-invalid @enderror" id="order" name="order"
                            value="{{ old('order', '0') }}" required min="0" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Menu Permissions & Record Limits -->
                <div class="mb-4" style="border: 1px solid var(--line, rgba(255, 255, 255, 0.12)); border-radius: var(--radius); padding: 24px; background: var(--bg-2, #0b1020);">
                    <label class="form-label-custom d-block" style="font-weight: 700; margin-bottom: 20px; font-size: 1.1rem; color: var(--text, #f8fafc);">Menu Permissions & Limits</label>
                    
                    <div class="permissions-grid">
                        
                        <!-- Booking Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="booking_menu" name="booking_menu" value="1" {{ old('booking_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('booking_menu').click();">Booking Menu</span>
                            </div>
                            <div id="booking_limit_container" class="limit-input-wrapper">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Bookings Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_bookings" id="no_of_bookings_unlimited" value="unlimited" {{ (old('limit_type_no_of_bookings') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_bookings', 'unlimited')" />
                                        <label for="no_of_bookings_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_bookings" id="no_of_bookings_limited" value="limited" {{ (old('limit_type_no_of_bookings', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_bookings', 'limited')" />
                                        <label for="no_of_bookings_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_bookings_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_bookings" id="no_of_bookings" class="limit-input-field @error('no_of_bookings') is-invalid @enderror" value="{{ old('no_of_bookings', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_bookings')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Vehicles Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="vehicles_menu" name="vehicles_menu" value="1" {{ old('vehicles_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('vehicles_menu').click();">Vehicles Menu</span>
                            </div>
                            <div id="vehicles_limit_container" class="limit-input-wrapper" style="flex-direction: column; gap: 12px; align-items: flex-end;">
                                <!-- Vehicles Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Vehicles Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_vehicles" id="no_of_vehicles_unlimited" value="unlimited" {{ (old('limit_type_no_of_vehicles') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_vehicles', 'unlimited')" />
                                        <label for="no_of_vehicles_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_vehicles" id="no_of_vehicles_limited" value="limited" {{ (old('limit_type_no_of_vehicles', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_vehicles', 'limited')" />
                                        <label for="no_of_vehicles_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_vehicles_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_vehicles" id="no_of_vehicles" class="limit-input-field @error('no_of_vehicles') is-invalid @enderror" value="{{ old('no_of_vehicles', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                <!-- Groups Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Groups Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_groups" id="no_of_groups_unlimited" value="unlimited" {{ (old('limit_type_no_of_groups') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_groups', 'unlimited')" />
                                        <label for="no_of_groups_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_groups" id="no_of_groups_limited" value="limited" {{ (old('limit_type_no_of_groups', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_groups', 'limited')" />
                                        <label for="no_of_groups_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_groups_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_groups" id="no_of_groups" class="limit-input-field @error('no_of_groups') is-invalid @enderror" value="{{ old('no_of_groups', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_vehicles')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('no_of_groups')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Locations Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="locations_menu" name="locations_menu" value="1" {{ old('locations_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('locations_menu').click();">Locations Menu</span>
                            </div>
                            <div id="locations_limit_container" class="limit-input-wrapper" style="flex-direction: column; gap: 12px; align-items: flex-end;">
                                <!-- Locations Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Locations Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_locations" id="no_of_locations_unlimited" value="unlimited" {{ (old('limit_type_no_of_locations') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_locations', 'unlimited')" />
                                        <label for="no_of_locations_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_locations" id="no_of_locations_limited" value="limited" {{ (old('limit_type_no_of_locations', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_locations', 'limited')" />
                                        <label for="no_of_locations_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_locations_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_locations" id="no_of_locations" class="limit-input-field @error('no_of_locations') is-invalid @enderror" value="{{ old('no_of_locations', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                <!-- Branches Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Branches Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_branches" id="no_of_branches_unlimited" value="unlimited" {{ (old('limit_type_no_of_branches') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_branches', 'unlimited')" />
                                        <label for="no_of_branches_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_branches" id="no_of_branches_limited" value="limited" {{ (old('limit_type_no_of_branches', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_branches', 'limited')" />
                                        <label for="no_of_branches_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_branches_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_branches" id="no_of_branches" class="limit-input-field @error('no_of_branches') is-invalid @enderror" value="{{ old('no_of_branches', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_locations')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('no_of_branches')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Customers Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="customers_menu" name="customers_menu" value="1" {{ old('customers_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('customers_menu').click();">Customers Menu</span>
                            </div>
                            <div id="customers_limit_container" class="limit-input-wrapper" style="flex-direction: column; gap: 12px; align-items: flex-end;">
                                <!-- Customers Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Customers Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_users" id="no_of_users_unlimited" value="unlimited" {{ (old('limit_type_no_of_users') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_users', 'unlimited')" />
                                        <label for="no_of_users_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_users" id="no_of_users_limited" value="limited" {{ (old('limit_type_no_of_users', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_users', 'limited')" />
                                        <label for="no_of_users_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_users_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_users" id="no_of_users" class="limit-input-field @error('no_of_users') is-invalid @enderror" value="{{ old('no_of_users', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                <!-- Invitations Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Invitations Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_invitations" id="no_of_invitations_unlimited" value="unlimited" {{ (old('limit_type_no_of_invitations') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_invitations', 'unlimited')" />
                                        <label for="no_of_invitations_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_invitations" id="no_of_invitations_limited" value="limited" {{ (old('limit_type_no_of_invitations', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_invitations', 'limited')" />
                                        <label for="no_of_invitations_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_invitations_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_invitations" id="no_of_invitations" class="limit-input-field @error('no_of_invitations') is-invalid @enderror" value="{{ old('no_of_invitations', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_users')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('no_of_invitations')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fleet Management Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="fleet_management_menu" name="fleet_management_menu" value="1" {{ old('fleet_management_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('fleet_management_menu').click();">Fleet Management Menu</span>
                            </div>
                        </div>

                        <!-- Extras Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="extras_menu" name="extras_menu" value="1" {{ old('extras_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('extras_menu').click();">Extras Menu</span>
                            </div>
                            <div id="extras_limit_container" class="limit-input-wrapper" style="flex-direction: column; gap: 12px; align-items: flex-end;">
                                <!-- Extras Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Extras Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_extras" id="no_of_extras_unlimited" value="unlimited" {{ (old('limit_type_no_of_extras') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_extras', 'unlimited')" />
                                        <label for="no_of_extras_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_extras" id="no_of_extras_limited" value="limited" {{ (old('limit_type_no_of_extras', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_extras', 'limited')" />
                                        <label for="no_of_extras_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_extras_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_extras" id="no_of_extras" class="limit-input-field @error('no_of_extras') is-invalid @enderror" value="{{ old('no_of_extras', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                <!-- Insurances Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Insurances Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_insurances" id="no_of_insurances_unlimited" value="unlimited" {{ (old('limit_type_no_of_insurances') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_insurances', 'unlimited')" />
                                        <label for="no_of_insurances_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_insurances" id="no_of_insurances_limited" value="limited" {{ (old('limit_type_no_of_insurances', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_insurances', 'limited')" />
                                        <label for="no_of_insurances_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_insurances_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_insurances" id="no_of_insurances" class="limit-input-field @error('no_of_insurances') is-invalid @enderror" value="{{ old('no_of_insurances', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                <!-- Features Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Features Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_features" id="no_of_features_unlimited" value="unlimited" {{ (old('limit_type_no_of_features') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_features', 'unlimited')" />
                                        <label for="no_of_features_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_features" id="no_of_features_limited" value="limited" {{ (old('limit_type_no_of_features', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_features', 'limited')" />
                                        <label for="no_of_features_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_features_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_features" id="no_of_features" class="limit-input-field @error('no_of_features') is-invalid @enderror" value="{{ old('no_of_features', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                <!-- Rules Limit -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Rules Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_rules" id="no_of_rules_unlimited" value="unlimited" {{ (old('limit_type_no_of_rules') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_rules', 'unlimited')" />
                                        <label for="no_of_rules_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_rules" id="no_of_rules_limited" value="limited" {{ (old('limit_type_no_of_rules', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_rules', 'limited')" />
                                        <label for="no_of_rules_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_rules_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_rules" id="no_of_rules" class="limit-input-field @error('no_of_rules') is-invalid @enderror" value="{{ old('no_of_rules', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_extras')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('no_of_insurances')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('no_of_features')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('no_of_rules')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Coupons Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="coupons_menu" name="coupons_menu" value="1" {{ old('coupons_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('coupons_menu').click();">Coupons Menu</span>
                            </div>
                            <div id="coupons_limit_container" class="limit-input-wrapper">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Coupons Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_coupons" id="no_of_coupons_unlimited" value="unlimited" {{ (old('limit_type_no_of_coupons') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_coupons', 'unlimited')" />
                                        <label for="no_of_coupons_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_coupons" id="no_of_coupons_limited" value="limited" {{ (old('limit_type_no_of_coupons', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_coupons', 'limited')" />
                                        <label for="no_of_coupons_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_coupons_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_coupons" id="no_of_coupons" class="limit-input-field @error('no_of_coupons') is-invalid @enderror" value="{{ old('no_of_coupons', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_coupons')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Support Ticket Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="support_ticket_menu" name="support_ticket_menu" value="1" {{ old('support_ticket_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('support_ticket_menu').click();">Support Ticket Menu</span>
                            </div>
                            <div id="support_tickets_limit_container" class="limit-input-wrapper">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="limit-input-label">Tickets Limit:</span>
                                    <div class="segmented-control">
                                        <input type="radio" name="limit_type_no_of_support_tickets" id="no_of_support_tickets_unlimited" value="unlimited" {{ (old('limit_type_no_of_support_tickets') === 'unlimited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_support_tickets', 'unlimited')" />
                                        <label for="no_of_support_tickets_unlimited">Unlimited</label>

                                        <input type="radio" name="limit_type_no_of_support_tickets" id="no_of_support_tickets_limited" value="limited" {{ (old('limit_type_no_of_support_tickets', 'limited') === 'limited') ? 'checked' : '' }} onchange="toggleLimitInputType('no_of_support_tickets', 'limited')" />
                                        <label for="no_of_support_tickets_limited">Set Limit</label>
                                    </div>
                                    <div id="no_of_support_tickets_input_wrapper" style="display: none;">
                                        <input type="number" name="no_of_support_tickets" id="no_of_support_tickets" class="limit-input-field @error('no_of_support_tickets') is-invalid @enderror" value="{{ old('no_of_support_tickets', 0) }}" min="0" placeholder="Limit count" />
                                    </div>
                                </div>
                                @error('no_of_support_tickets')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Settings Menu -->
                        <div class="menu-permission-card">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 260px; flex-shrink: 0;">
                                <label class="theme-switch">
                                    <input type="checkbox" id="settings_menu" name="settings_menu" value="1" {{ old('settings_menu', '1') ? 'checked' : '' }} />
                                    <span class="slider round"></span>
                                </label>
                                <span class="menu-title-text" onclick="document.getElementById('settings_menu').click();">Settings Menu</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Status Toggle -->
                <div class="mb-4" style="border: 1px solid var(--line, rgba(255, 255, 255, 0.12)); border-radius: var(--radius); padding: 16px 20px; background: rgba(255, 255, 255, 0.03); max-width: 600px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <label class="theme-switch" style="margin: 0;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} />
                            <span class="slider round"></span>
                        </label>
                        <div>
                            <label for="is_active" class="menu-title-text" style="margin: 0; font-size: 0.95rem; display: block; cursor: pointer;">Active Status</label>
                            <span style="font-size: 0.8rem; color: var(--muted, #a8b3c5);">Enable / Publish this package</span>
                        </div>
                    </div>
                    @error('is_active')
                        <div class="invalid-feedback d-block" style="margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <style>
                    .permissions-grid {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 16px;
                    }
                    @media (max-width: 991px) {
                        .permissions-grid {
                            grid-template-columns: 1fr;
                        }
                    }

                    /* Custom Switch Premium CSS Toggle */
                    .menu-permission-card {
                        display: flex;
                        flex-wrap: wrap;
                        align-items: center;
                        justify-content: flex-start;
                        gap: 24px;
                        padding: 16px 20px;
                        background: rgba(255, 255, 255, 0.03);
                        border: 1px solid rgba(255, 255, 255, 0.08);
                        border-radius: var(--radius, 8px);
                        transition: all 0.2s ease-in-out;
                        align-self: start;
                    }
                    .menu-permission-card:hover {
                        border-color: var(--brand, #52ead2);
                        box-shadow: 0 0 15px rgba(82, 234, 210, 0.15);
                        background: rgba(255, 255, 255, 0.05);
                    }
                    .menu-title-text {
                        font-size: 0.95rem;
                        color: var(--text, #f8fafc);
                        font-weight: 700;
                        cursor: pointer;
                        user-select: none;
                    }
                    .theme-switch {
                        position: relative;
                        display: inline-block;
                        width: 44px;
                        height: 22px;
                        margin: 0;
                    }
                    .theme-switch input {
                        opacity: 0;
                        width: 0;
                        height: 0;
                    }
                    .slider {
                        position: absolute;
                        cursor: pointer;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-color: rgba(255, 255, 255, 0.15);
                        transition: .3s;
                    }
                    .slider:before {
                        position: absolute;
                        content: "";
                        height: 16px;
                        width: 16px;
                        left: 3px;
                        bottom: 3px;
                        background-color: white;
                        transition: .3s;
                    }
                    .slider.round {
                        border-radius: 22px;
                    }
                    .slider.round:before {
                        border-radius: 50%;
                    }
                    .theme-switch input:checked + .slider {
                        background-color: var(--brand, #52ead2);
                    }
                    .theme-switch input:focus + .slider {
                        box-shadow: 0 0 1px var(--brand, #52ead2);
                    }
                    .theme-switch input:checked + .slider:before {
                        transform: translateX(22px);
                    }

                    /* Custom Segmented Control */
                    .segmented-control {
                        display: inline-flex;
                        background: rgba(255, 255, 255, 0.05);
                        padding: 2px;
                        border-radius: 6px;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }
                    .segmented-control input[type="radio"] {
                        display: none;
                    }
                    .segmented-control label {
                        font-size: 0.8rem;
                        font-weight: 700;
                        color: var(--muted, #a8b3c5);
                        padding: 6px 12px;
                        border-radius: 4px;
                        cursor: pointer;
                        margin: 0;
                        transition: all 0.2s;
                        user-select: none;
                    }
                    .segmented-control input[type="radio"]:checked + label {
                        background: var(--brand, #52ead2);
                        color: #050711;
                    }

                    /* Inline Limits */
                    .limit-input-wrapper {
                        display: none; /* Controlled by JS */
                        align-items: flex-end;
                        gap: 10px;
                        animation: slideIn 0.25s ease-out;
                    }
                    .limit-input-label {
                        font-size: 0.85rem;
                        color: var(--muted, #a8b3c5);
                        font-weight: 600;
                        margin: 0;
                    }
                    .limit-input-field {
                        background: rgba(255, 255, 255, 0.05);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        border-radius: var(--radius, 8px);
                        padding: 6px 10px;
                        font-size: 0.9rem;
                        color: var(--text, #f8fafc);
                        width: 110px;
                        outline: none;
                        transition: border-color 0.2s;
                    }
                    .limit-input-field:focus {
                        border-color: var(--brand, #52ead2);
                        background: rgba(255, 255, 255, 0.08);
                    }

                    @keyframes slideIn {
                        from {
                            opacity: 0;
                            transform: translateX(-10px);
                        }
                        to {
                            opacity: 1;
                            transform: translateX(0);
                        }
                    }

                    /* Disabled Input custom styling for Dark Theme */
                    .form-input-custom:disabled {
                        background-color: rgba(255, 255, 255, 0.05) !important;
                        color: rgba(255, 255, 255, 0.3) !important;
                        border-color: rgba(255, 255, 255, 0.08) !important;
                        cursor: not-allowed;
                    }
                </style>

                <script>
                    function toggleLimitInputType(prefix, type) {
                        const wrapper = document.getElementById(prefix + '_input_wrapper');
                        const input = document.getElementById(prefix);
                        if (wrapper) {
                            if (type === 'limited') {
                                wrapper.style.display = 'block';
                                if (input && (input.value === '' || input.value === null)) {
                                    input.value = '0'; // default value when clicking Set Limit
                                }
                            } else {
                                wrapper.style.display = 'none';
                                if (input) {
                                    input.value = ''; // clear for Unlimited
                                }
                            }
                        }
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        const limitPairs = [
                            ['booking_menu', 'booking_limit_container'],
                            ['vehicles_menu', 'vehicles_limit_container'],
                            ['locations_menu', 'locations_limit_container'],
                            ['customers_menu', 'customers_limit_container'],
                            ['extras_menu', 'extras_limit_container'],
                            ['coupons_menu', 'coupons_limit_container'],
                            ['support_ticket_menu', 'support_tickets_limit_container']
                        ];

                        function toggleLimit(switchId, containerId) {
                            const sw = document.getElementById(switchId);
                            const container = document.getElementById(containerId);
                            if (sw && container) {
                                if (sw.checked) {
                                    container.style.display = 'flex';
                                } else {
                                    container.style.display = 'none';
                                }
                            }
                        }

                        limitPairs.forEach(pair => {
                            const sw = document.getElementById(pair[0]);
                            if (sw) {
                                sw.addEventListener('change', function() {
                                    toggleLimit(pair[0], pair[1]);
                                });
                                // Initialize state
                                toggleLimit(pair[0], pair[1]);
                            }
                        });

                        // Initialize Segmented Controls based on radio state
                        const limitPrefixes = [
                            'no_of_bookings',
                            'no_of_vehicles',
                            'no_of_groups',
                            'no_of_locations',
                            'no_of_branches',
                            'no_of_users',
                            'no_of_invitations',
                            'no_of_extras',
                            'no_of_insurances',
                            'no_of_features',
                            'no_of_rules',
                            'no_of_coupons',
                            'no_of_support_tickets'
                        ];

                        limitPrefixes.forEach(prefix => {
                            const limitedRadio = document.getElementById(prefix + '_limited');
                            const wrapper = document.getElementById(prefix + '_input_wrapper');
                            
                            if (wrapper) {
                                if (limitedRadio && limitedRadio.checked) {
                                    wrapper.style.display = 'block';
                                } else {
                                    wrapper.style.display = 'none';
                                }
                            }
                        });

                        // Billing period dropdown switcher & Is Free checkbox
                        const billingPeriodSelect = document.getElementById('billing_period');
                        const isFreeCheckbox = document.getElementById('is_free_pkg');
                        const priceInput = document.getElementById('price');

                        function updateBillingFields() {
                            const selectedValue = billingPeriodSelect ? billingPeriodSelect.value : '';
                            const isFree = isFreeCheckbox ? isFreeCheckbox.checked : false;

                            if (isFree) {
                                if (priceInput) {
                                    priceInput.value = 'Free';
                                    priceInput.setAttribute('disabled', 'true');
                                    let hiddenPriceInput = document.getElementById('hidden_price');
                                    if (!hiddenPriceInput) {
                                        hiddenPriceInput = document.createElement('input');
                                        hiddenPriceInput.type = 'hidden';
                                        hiddenPriceInput.id = 'hidden_price';
                                        hiddenPriceInput.name = 'price';
                                        hiddenPriceInput.value = 'Free';
                                        priceInput.parentNode.appendChild(hiddenPriceInput);
                                    } else {
                                        hiddenPriceInput.value = 'Free';
                                    }
                                }
                            } else if (selectedValue === '') {
                                if (priceInput) {
                                    priceInput.value = 'Custom';
                                    priceInput.setAttribute('disabled', 'true');
                                    let hiddenPriceInput = document.getElementById('hidden_price');
                                    if (!hiddenPriceInput) {
                                        hiddenPriceInput = document.createElement('input');
                                        hiddenPriceInput.type = 'hidden';
                                        hiddenPriceInput.id = 'hidden_price';
                                        hiddenPriceInput.name = 'price';
                                        hiddenPriceInput.value = 'Custom';
                                        priceInput.parentNode.appendChild(hiddenPriceInput);
                                    } else {
                                        hiddenPriceInput.value = 'Custom';
                                    }
                                }
                            } else {
                                if (priceInput) {
                                    priceInput.removeAttribute('disabled');
                                    if (priceInput.value === 'Custom' || priceInput.value === 'Free') {
                                        priceInput.value = '';
                                    }
                                    const hiddenPriceInput = document.getElementById('hidden_price');
                                    if (hiddenPriceInput) {
                                        hiddenPriceInput.remove();
                                    }
                                }
                            }
                        }

                        if (billingPeriodSelect) {
                            billingPeriodSelect.addEventListener('change', updateBillingFields);
                        }
                        if (isFreeCheckbox) {
                            isFreeCheckbox.addEventListener('change', updateBillingFields);
                        }
                        // Initial call on page load
                        updateBillingFields();
                    });
                </script>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Create Package</button>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
