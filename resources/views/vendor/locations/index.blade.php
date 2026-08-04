@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h2 style="margin: 0; font-size: 1.35rem; font-weight: 800;">Pickup Location Management</h2>
            </div>
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: nowrap;">

                <button type="button" onclick="openAddLocationModal()" class="btn" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); white-space: nowrap; flex-shrink: 0; transition: all 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Location
                </button>
            </div>
        </div>

        <div id="locationsTableContainer">
            @section('locations_table_section')
            <div class="panel-body admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">S.No</th>
                            <th style="white-space: nowrap;">Type</th>
                            <th style="white-space: nowrap;">Pickup Location</th>
                            <th style="white-space: nowrap;">Location Price</th>
                            <th style="white-space: nowrap;">Map Type</th>
                            <th style="white-space: nowrap; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startingNumber = ($locations->currentPage() - 1) * $locations->perPage() + 1;
                        @endphp
                        @forelse ($locations as $loc)
                            <tr id="location-row-{{ $loc->id }}">
                                <td>{{ $startingNumber++ }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(82, 234, 210, 0.15); color: var(--brand, #52ead2); font-weight: 700; padding: 4px 8px; border-radius: 6px;">{{ $loc->type }}</span>
                                </td>
                                <td>
                                    <strong>{{ $loc->location }}</strong>
                                </td>
                                <td>
                                    {{ number_format($loc->price, 2) }}
                                </td>
                                <td>
                                    @if($loc->map_type === 'coordinates')
                                        <span style="color: #94a3b8; font-size: 0.85rem;">Coordinates</span>
                                    @else
                                        <span style="color: #94a3b8; font-size: 0.85rem;">Embedded Map</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div class="table-actions" style="display: inline-flex; gap: 8px; justify-content: flex-end;">
                                        <button type="button" class="icon-button edit-location-btn" title="Edit Location"
                                                data-id="{{ $loc->id }}"
                                                data-type="{{ $loc->type }}"
                                                data-location="{{ $loc->location }}"
                                                data-price="{{ $loc->price }}"
                                                data-map_type="{{ $loc->map_type }}"
                                                data-latitude="{{ $loc->latitude ?? '' }}"
                                                data-longitude="{{ $loc->longitude ?? '' }}"
                                                data-map_embed="{{ $loc->map_embed ?? '' }}"
                                                style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(82,234,210,0.3); border-radius: 4px; color: #52ead2; background: rgba(82,234,210,0.1); cursor: pointer;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        </button>
                                        <button type="button" class="icon-button ajax-delete-location-btn" title="Delete Location"
                                                data-id="{{ $loc->id }}"
                                                data-name="{{ $loc->location }}"
                                                style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(239,68,68,0.3); border-radius: 4px; color: #ef4444; background: rgba(239,68,68,0.1); cursor: pointer;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:32px;color:#94a3b8;">
                                    <svg viewBox="0 0 24 24" style="width:40px;height:40px;fill:none;stroke:#cbd5e1;stroke-width:1.5;display:block;margin:0 auto 10px;">
                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    No pickup locations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($locations->hasPages())
                <div style="border-top:1px solid rgba(255,255,255,0.05);display:flex;justify-content:space-between;align-items:center;padding:16px 24px;">
                    <div class="text-muted small">
                        Showing {{ $locations->firstItem() ?? 0 }} to {{ $locations->lastItem() ?? 0 }}
                        of {{ $locations->total() }} results
                    </div>
                    <div>{{ $locations->links('vendor.pagination.custom') }}</div>
                </div>
            @endif
            @endsection
            @yield('locations_table_section')
        </div>
    </div>

    <!-- Add / Edit Location Modal -->
    <div id="locationModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: var(--bg-card, #1e293b); border: 1px solid var(--line, #334155); border-radius: 12px; width: 100%; max-width: 600px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); overflow: hidden;">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--line, #334155); display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text, #f8fafc);" id="locationModalTitle">
                    Add Pickup Location
                </h5>
                <button type="button" onclick="closeLocationModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <form id="locationForm" onsubmit="event.preventDefault(); submitLocationModalForm(event); return false;">
                @csrf
                <input type="hidden" id="modal_loc_id" value="">
                <div style="padding: 20px;">
                    <div class="row" style="display: flex; flex-wrap: wrap; margin: -8px;">
                        <div style="width: 50%; padding: 8px; box-sizing: border-box;">
                            <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Type *</label>
                            <select name="type" id="modal_type" class="form-select dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" required>
                                <option value="">Select Type</option>
                                @foreach($types as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="width: 50%; padding: 8px; box-sizing: border-box;">
                            <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Price *</label>
                            <input type="number" step="0.01" min="0" name="price" id="modal_price" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" required placeholder="0.00">
                        </div>
                    </div>

                    <div style="margin-top: 12px;">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Pickup Location *</label>
                        <input type="text" name="location" id="modal_location" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" required placeholder="e.g. Airport Terminal 1, City Center">
                    </div>

                    <div class="row" style="display: flex; flex-wrap: wrap; margin: -8px; margin-top: 12px;">
                        <div style="width: 100%; padding: 8px; box-sizing: border-box;">
                            <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Map Type</label>
                            <select name="map_type" id="modal_map_type" onchange="toggleModalMapFields(this.value)" class="form-select dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;">
                                <option value="coordinates">Coordinates</option>
                                <option value="embedded">Embedded Map (iframe)</option>
                            </select>
                        </div>
                    </div>

                    <div id="modal_field_coords" class="row" style="display: flex; flex-wrap: wrap; margin: -8px; margin-top: 4px;">
                        <div style="width: 50%; padding: 8px; box-sizing: border-box;">
                            <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Latitude</label>
                            <input type="text" name="latitude" id="modal_latitude" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" placeholder="e.g. 28.6139">
                        </div>
                        <div style="width: 50%; padding: 8px; box-sizing: border-box;">
                            <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Longitude</label>
                            <input type="text" name="longitude" id="modal_longitude" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" placeholder="e.g. 77.2090">
                        </div>
                    </div>

                    <div id="modal_field_embed" style="display: none; margin-top: 12px;">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Map Embed Code (iframe)</label>
                        <textarea name="map_embed" id="modal_map_embed" rows="3" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" placeholder="Paste Google Maps iframe code..."></textarea>
                    </div>
                </div>
                <div style="padding: 14px 20px; border-top: 1px solid var(--line, #334155); display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeLocationModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Cancel</button>
                    <button type="submit" id="btnLocationSubmit" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border: none; font-weight: 800 !important; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35);">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    var currentLocationSearchQuery = '';
    var locationSearchTimer = null;

    function toggleModalMapFields(val) {
        if (val === 'coordinates') {
            $('#modal_field_coords').css('display', 'flex');
            $('#modal_field_embed').css('display', 'none');
        } else {
            $('#modal_field_coords').css('display', 'none');
            $('#modal_field_embed').css('display', 'block');
        }
    }

    function fetchLocations(url) {
        url = url || '{{ route("vendor.locations.index") }}';
        $('#locationsTableContainer').css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: currentLocationSearchQuery
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.html) {
                    $('#locationsTableContainer').html(response.html).css('opacity', '1');
                }
            },
            error: function() {
                $('#locationsTableContainer').css('opacity', '1');
            }
        });
    }

    function openAddLocationModal() {
        $('#modal_loc_id').val('');
        $('#modal_type').val('');
        $('#modal_location').val('');
        $('#modal_price').val('');
        $('#modal_map_type').val('coordinates');
        $('#modal_latitude').val('');
        $('#modal_longitude').val('');
        $('#modal_map_embed').val('');
        toggleModalMapFields('coordinates');
        $('#locationModalTitle').text('Add Pickup Location');
        $('#locationModal').css('display', 'flex');
    }

    function openEditLocationModal(id, type, location, price, map_type, latitude, longitude, map_embed) {
        $('#modal_loc_id').val(id);
        $('#modal_type').val(type);
        $('#modal_location').val(location);
        $('#modal_price').val(price);
        $('#modal_map_type').val(map_type || 'coordinates');
        $('#modal_latitude').val(latitude);
        $('#modal_longitude').val(longitude);
        $('#modal_map_embed').val(map_embed);
        toggleModalMapFields(map_type || 'coordinates');
        $('#locationModalTitle').text('Edit Pickup Location');
        $('#locationModal').css('display', 'flex');
    }

    function closeLocationModal() {
        $('#locationModal').css('display', 'none');
    }

    function submitLocationModalForm(e) {
        if (e && e.preventDefault) e.preventDefault();
        var locId = $('#modal_loc_id').val();
        var isEdit = !!locId;
        var url = isEdit ? '{{ url("vendor/locations") }}/' + locId : '{{ route("vendor.locations.store") }}';
        var method = isEdit ? 'PUT' : 'POST';

        var typeVal = $('#modal_type').val();
        var locationVal = $('#modal_location').val();
        var priceVal = $('#modal_price').val();

        if (!typeVal || !locationVal || priceVal === '') {
            Swal.fire('Error!', 'Please fill all required fields.', 'error');
            return false;
        }

        $('#btnLocationSubmit').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: method,
                type: typeVal,
                location: locationVal,
                price: priceVal,
                map_type: $('#modal_map_type').val(),
                latitude: $('#modal_latitude').val(),
                longitude: $('#modal_longitude').val(),
                map_embed: $('#modal_map_embed').val()
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success) {
                    closeLocationModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Location saved successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    fetchLocations();
                } else {
                    Swal.fire('Error!', response.message || 'Failed to save location.', 'error');
                }
            },
            error: function(xhr) {
                var errorMsg = 'An error occurred while saving location.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = [];
                    $.each(xhr.responseJSON.errors, function(key, msgs) {
                        errs.push(msgs.join(', '));
                    });
                    errorMsg = errs.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Validation Error!', errorMsg, 'error');
            },
            complete: function() {
                $('#btnLocationSubmit').prop('disabled', false).text('Save');
            }
        });

        return false;
    }

    $(document).ready(function() {
        // Edit location button click
        $(document).on('click', '.edit-location-btn', function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            var location = $(this).data('location');
            var price = $(this).data('price');
            var map_type = $(this).data('map_type');
            var latitude = $(this).data('latitude');
            var longitude = $(this).data('longitude');
            var map_embed = $(this).data('map_embed');
            openEditLocationModal(id, type, location, price, map_type, latitude, longitude, map_embed);
        });

        // Delete location button click
        $(document).on('click', '.ajax-delete-location-btn', function() {
            var locId = $(this).data('id');
            var locName = $(this).data('name') || 'this location';
            var $row = $('#location-row-' + locId);

            Swal.fire({
                title: 'Delete Location?',
                text: 'Are you sure you want to delete "' + locName + '"? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("vendor/locations") }}/' + locId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        dataType: 'json',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        success: function(response) {
                            if (response.success) {
                                $row.fadeOut(300, function() {
                                    $(this).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message || 'Location deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete location.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete location.', 'error');
                        }
                    });
                }
            });
        });

        // Search input keyup
        $(document).on('keyup', '#locationSearchInput', function() {
            clearTimeout(locationSearchTimer);
            currentLocationSearchQuery = $(this).val();
            locationSearchTimer = setTimeout(function() {
                fetchLocations();
            }, 350);
        });

        // AJAX Pagination click
        $(document).on('click', '#locationsTableContainer .pagination a', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            if (pageUrl) {
                fetchLocations(pageUrl);
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection
