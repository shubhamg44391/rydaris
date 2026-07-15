<script>
    let currentYear = {{ date('Y') }}; // Default or from server
    let currentMonth = 'next30';

    function setYear(year, el) {
        currentYear = year;
        document.querySelectorAll('#yearFilters .chip').forEach(c => c.classList.remove('active-blue'));
        el.classList.add('active-blue');
        
        // Clear date range to let Year/Month take priority
        if(typeof dateRangePicker !== 'undefined' && dateRangePicker) {
            dateRangePicker.clear();
        }
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';

        // If month is Next 30 Days, but year is different from current, default to January
        if (currentMonth === 'next30' && year != {{ (int)date('Y') }}) {
            currentMonth = 1;
            document.querySelectorAll('#monthFilters .chip').forEach(c => c.classList.remove('active-blue'));
            let janChip = document.querySelector('#monthFilters .chip[data-month="1"]');
            if(janChip) janChip.classList.add('active-blue');
            document.getElementById('viewingText').innerText = 'January';
        }

        fetchRates();
    }

    function setMonth(el, month) {
        currentMonth = month;
        document.querySelectorAll('#monthFilters .chip').forEach(c => c.classList.remove('active-blue'));
        el.classList.add('active-blue');
        
        let label = el.innerText;
        document.getElementById('viewingText').innerText = label;
        
        // Clear date range to let Year/Month take priority
        if(typeof dateRangePicker !== 'undefined' && dateRangePicker) {
            dateRangePicker.clear();
        }
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';

        // If Next 30 Days is clicked, enforce current year
        if (month === 'next30') {
            currentYear = {{ (int)date('Y') }};
            document.querySelectorAll('#yearFilters .chip').forEach(c => c.classList.remove('active-blue'));
            let currentYearChip = Array.from(document.querySelectorAll('#yearFilters .chip')).find(c => c.innerText.trim() == currentYear);
            if(currentYearChip) currentYearChip.classList.add('active-blue');
        }

        fetchRates();
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Use pre-loaded data if available, otherwise fetch
        const initial = @json($initialData ?? null);
        if (initial && initial.data) {
            renderTable(initial.data, initial.dates);
            if(initial.dates.length > 0) {
                document.getElementById('dateRangeText').innerText = initial.dates[0] + ' to ' + initial.dates[initial.dates.length - 1];
            }
        } else {
            fetchRates();
        }
    });

    function toggleGroup(el) {
        el.classList.toggle('active-green');
        updateGroupsText();
        fetchRates();
    }
    
    function selectAllGroups(selectAll) {
        document.querySelectorAll('.group-chip').forEach(c => {
            if (selectAll) c.classList.add('active-green');
            else c.classList.remove('active-green');
        });
        updateGroupsText();
        fetchRates();
    }

    function updateGroupsText() {
        const active = Array.from(document.querySelectorAll('.group-chip.active-green')).map(c => c.innerText);
        document.getElementById('groupsText').innerText = active.length > 0 ? active.join(', ') : 'None';
    }

    function getSelectedGroups() {
        return Array.from(document.querySelectorAll('.group-chip.active-green')).map(cb => cb.dataset.id);
    }

    function fetchRates() {
        document.getElementById('dateRangeText').innerText = 'Fetching...';
        
        const badge = document.getElementById('statusBadge');
        if (badge) {
            badge.style.background = '#fffbeb';
            badge.style.borderColor = '#fde68a';
            badge.style.color = '#d97706';
            badge.innerHTML = `<svg viewBox="0 0 24 24" class="spin" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg> Fetching...`;
        }
        
        const data = {
            year: currentYear,
            month: currentMonth,
            start_date: document.getElementById('dateStart') ? document.getElementById('dateStart').value : '',
            end_date: document.getElementById('dateEnd') ? document.getElementById('dateEnd').value : '',
            group_ids: typeof filterGroupId !== 'undefined' && filterGroupId ? [filterGroupId] : getSelectedGroups(),
            vehicle_id: typeof filterVehicleId !== 'undefined' ? filterVehicleId : null,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route('vendor.availability.fetch-rates') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                renderTable(res.data, res.dates);
                document.getElementById('dateRangeText').innerText = res.dates.length > 0 
                    ? res.dates[0] + ' to ' + res.dates[res.dates.length - 1] 
                    : 'No dates selected';
            }
        });
    }

    function renderTable(matrix, dates) {
        const thead = document.getElementById('tableHeader');
        const tbody = document.getElementById('tableBody');
        
        let daysCount = 31;
        let year = currentYear;
        let month = currentMonth;
        if (month === 'next30') {
            let today = new Date();
            daysCount = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        } else {
            daysCount = new Date(year, parseInt(month), 0).getDate();
        }
        
        // Build Header
        let hHtml = '<th style="background-color: #0b1020 !important;">Pickup Date</th><th style="background-color: #0b1020 !important;">ACRISS / VEHICLE</th>';
        for(let i=1; i<=daysCount; i++) {

            hHtml += `<th>Day ${i}</th>`;
        }
        thead.innerHTML = hHtml;
        
        // Build Body
        let bHtml = '';
        const groupIds = Object.keys(matrix);
        
        if (groupIds.length === 0 || dates.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${daysCount + 2}" style="padding:20px; text-align:center; color: var(--muted-2, #a1a1aa);">No data found.</td></tr>`;
            return;
        }

        let dateIndex = 0;
        dates.forEach(date => {
            let isFirstRowForDate = true;
            let totalRowsForDate = 0;
            
            // Calculate rowspan for date cell
            groupIds.forEach(gid => {
                if (!(typeof filterVehicleId !== 'undefined' && filterVehicleId)) {
                    totalRowsForDate += 1; // Group row
                }
                totalRowsForDate += Object.keys(matrix[gid].vehicles || {}).length; // Vehicle rows
            });

            let altRow = false;
            groupIds.forEach(gid => {
                const group = matrix[gid];
                const gRates = group.dates[date] || {};
                
                // Group Row (Hide if in Single Vehicle mode)
                if (!(typeof filterVehicleId !== 'undefined' && filterVehicleId)) {
                    bHtml += `<tr class="row-group ${altRow ? 'alt' : ''}">`;
                    
                    if (isFirstRowForDate) {
                        bHtml += `<td class="sticky-date" rowspan="${totalRowsForDate}" style="vertical-align: top; padding-top: 20px; background-color: #0b1020 !important;">${date}</td>`;
                        isFirstRowForDate = false;
                    }
                    
                    const groupBg = altRow ? '#141b2b' : '#27141f';
                    bHtml += `<td class="sticky-group" style="background-color: ${groupBg} !important;">[G] ${group.name}</td>`;
                    
                    for(let i=1; i<=daysCount; i++) {
                        const price = gRates[i] ? gRates[i].price.toFixed(2) : '0.00';
                        const cls = 'cell-price';
                        bHtml += `<td class="${cls}" data-date="${date}" data-day="${i}" data-gid="${gid}">${price}</td>`;
                    }
                    bHtml += '</tr>';
                }

                // Vehicle Sub-rows
                const vIds = Object.keys(group.vehicles || {});
                vIds.forEach(vid => {
                    const vehicle = group.vehicles[vid];
                    const vRates = vehicle.dates[date] || {};
                    
                    bHtml += `<tr class="row-vehicle">`;
                    
                    if (isFirstRowForDate && (typeof filterVehicleId !== 'undefined' && filterVehicleId)) {
                        bHtml += `<td class="sticky-date" rowspan="${totalRowsForDate}" style="vertical-align: top; padding-top: 20px; background-color: #0b1020 !important;">${date}</td>`;
                        isFirstRowForDate = false;
                    }

                    bHtml += `<td class="sticky-group" style="background-color: #251e12 !important;">&bull; ${vehicle.name}</td>`;
                    
                    for(let i=1; i<=daysCount; i++) {
                        const price = vRates[i] ? vRates[i].price.toFixed(2) : (gRates[i] ? gRates[i].price.toFixed(2) : '0.00');
                        const cls = 'cell-price';
                        bHtml += `<td class="${cls}" data-date="${date}" data-day="${i}" data-gid="${gid}" data-vid="${vid}">${price}</td>`;
                    }
                    bHtml += '</tr>';
                });

                
                altRow = !altRow;
            });
            dateIndex++;
        });
        
        tbody.innerHTML = bHtml;
        attachCellEvents();
        
        const badge = document.getElementById('statusBadge');
        if (badge) {
            badge.style.background = '#ecfdf5';
            badge.style.borderColor = '#a7f3d0';
            badge.style.color = '#059669';
            badge.innerHTML = `<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Ready`;
        }
    }

    function attachCellEvents() {
        document.querySelectorAll('.cell-price').forEach(cell => {
            cell.addEventListener('dblclick', function() {
                if(this.querySelector('input')) return; // already editing
                
                const val = this.innerText;
                const date = this.dataset.date;
                const day = this.dataset.day;
                const gid = this.dataset.gid;
                const vid = this.dataset.vid || null;
                
                this.innerHTML = `<input type="number" class="cell-input" style="min-width: 50px;" value="${val !== '0.00' ? val : ''}" />`;
                const input = this.querySelector('input');
                input.focus();
                
                input.addEventListener('blur', function() {
                    saveSingleRate(this.value, date, day, gid, vid, cell);
                });
                input.addEventListener('keydown', function(e) {
                    if(e.key === 'Enter') this.blur();
                });
            });
        });
    }

    function saveSingleRate(price, date, day, gid, vid, cell) {
        if (price === '' || price === null || isNaN(price)) {
            price = 0;
        }

        // Optimistic UI Update (immediate visual feedback)
        cell.innerText = parseFloat(price).toFixed(2);
        
        fetch('{{ route('vendor.availability.update-rate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                date: date,
                day: day,
                price: price,
                group_id: gid,
                vehicle_id: vid,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                // successfully saved in background
            } else {
                alert(res.message);
                cell.innerText = '0.00';
            }
        })
        .catch(err => {
            console.error(err);
            cell.innerText = 'Error';
        });
    }

    function copyRates() {
        let updates = [];
        
        let day1Cells = document.querySelectorAll('.cell-price[data-day="1"]');
        
        day1Cells.forEach(cell => {
            let price = parseFloat(cell.innerText);
            if (isNaN(price)) price = 0;
            
            let date = cell.dataset.date;
            let gid = cell.dataset.gid;
            let vid = cell.dataset.vid || null;
            
            updates.push({
                date: date,
                group_id: gid,
                vehicle_id: vid,
                price: price
            });
            
            // Optimistic UI update
            let row = cell.closest('tr');
            let otherCells = row.querySelectorAll('.cell-price');
            let formattedPrice = price.toFixed(2);
            otherCells.forEach(c => {
                c.innerText = formattedPrice;
            });
        });
        
        if (updates.length === 0) return;
        
        const badge = document.getElementById('statusBadge');
        let originalBadgeHtml = badge ? badge.innerHTML : '';
        if (badge) {
            badge.innerHTML = 'Saving...';
        }

        fetch('{{ route('vendor.availability.bulk-copy-day1') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                updates: updates,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json())
        .then(res => {
            if(badge) {
                badge.innerHTML = 'Copied successfully!';
                setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
            }
        })
        .catch(err => {
            console.error(err);
            if(badge) {
                badge.innerHTML = 'Error copying!';
                setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
            }
        });
    }

    function exportRates() {
        window.location.href = '{{ route("vendor.availability.export") }}';
    }

    function triggerImport() {
        document.getElementById('csvFileInput').click();
    }

    function handleImport(event) {
        const file = event.target.files[0];
        if (!file) return;

        const badge = document.getElementById('statusBadge');
        let originalBadgeHtml = badge ? badge.innerHTML : '';
        if (badge) badge.innerHTML = 'Importing...';

        const formData = new FormData();
        formData.append('csv_file', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("vendor.availability.import-csv") }}', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(badge) {
                    badge.innerHTML = 'Imported successfully!';
                    setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
                }
                fetchRates(); // Reload table
            } else {
                alert('Import failed: ' + (res.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error(err);
            if(badge) {
                badge.innerHTML = 'Error importing!';
                setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
            }
        })
        .finally(() => {
            event.target.value = ''; // Reset input
        });
    }

    function openHistoryModal() {
        document.getElementById('historyModal').style.display = 'flex';
        const tbody = document.getElementById('historyBody');
        tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">Loading...</td></tr>';
        
        fetch('{{ route("vendor.availability.history") }}')
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(res.history.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">No history found.</td></tr>';
                    return;
                }
                let html = '';
                res.history.forEach(item => {
                    const date = new Date(item.created_at).toLocaleString();
                    html += `<tr>
                        <td style="text-align:left;">${date}</td>
                        <td style="text-align:left; text-transform:uppercase; font-size:0.8rem; font-weight:bold;">${item.action_type.replace('_', ' ')}</td>
                        <td style="text-align:left; font-size:0.85rem; color: var(--muted-2, #a1a1aa);">${item.details || ''}</td>
                    </tr>`;
                });
                tbody.innerHTML = html;
            }
        })
        .catch(err => console.error(err));
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').style.display = 'none';
    }

    function renderBulkDaysCheckboxes() {
        const bulkDaysContainer = document.getElementById('bulkDays');
        if (!bulkDaysContainer) return;
        
        let daysCount = 31;
        let year = currentYear;
        let month = currentMonth;
        if (month === 'next30') {
            let today = new Date();
            daysCount = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        } else {
            daysCount = new Date(year, parseInt(month), 0).getDate();
        }
        
        let html = '';
        for (let i = 1; i <= daysCount; i++) {
            html += `
                <label style="border: 1px solid var(--line); background: var(--bg-2); border-radius:4px; padding:6px 10px; display:flex; align-items:center; gap:8px; font-size:0.8rem; cursor:pointer; font-weight:600; color: var(--text); white-space:nowrap;">
                    <input type="checkbox" value="${i}" class="bulk-day-cb" checked onchange="updateBulkPreview()" style="margin:0; width:16px; height:16px; flex-shrink:0;">
                    Day ${i}
                </label>
            `;
        }
        bulkDaysContainer.innerHTML = html;
    }

    // Modal Logic
    function openBulkModal() { 
        renderBulkDaysCheckboxes();
        document.getElementById('bulkModal').style.display = 'flex'; 
        setBulkRange('7'); // default selection
    }
    function closeBulkModal() { document.getElementById('bulkModal').style.display = 'none'; }
    
    function setBulkRange(days) {
        const fromDate = new Date(); // assume starting from today for preset ranges
        let toDate = new Date();
        const customContainer = document.getElementById('customDateContainer');
        const bulkFrom = document.getElementById('bulkFrom');
        const bulkTo = document.getElementById('bulkTo');
        
        if(days === 'custom') {
            customContainer.style.display = 'flex';
            // Show fields but don't set default value automatically
            bulkFrom.value = '';
            bulkTo.value = '';
        } else {
            customContainer.style.display = 'none';
            
            // For car rentals, 7 days means 8 calendar dates (e.g. 1st to 8th)
            toDate.setDate(fromDate.getDate() + parseInt(days));
            
            bulkFrom.value = fromDate.toISOString().split('T')[0];
            bulkTo.value = toDate.toISOString().split('T')[0];
        }
        
        // Update button styles exactly as per mockup
        const btns = document.querySelectorAll('.date-range-btn');
        btns.forEach(b => b.classList.remove('active'));
        const clickedBtn = Array.from(btns).find(b => b.innerText.includes(days === '7' ? '7 Days' : days === '30' ? 'Month' : days === '90' ? '3 Months' : 'Custom'));
        if(clickedBtn) {
            clickedBtn.classList.add('active');
        }
        
        updateBulkPreview();
    }
    
    function toggleBulkGroupChip(el) {
        el.classList.toggle('active-green');
    }
    
    function toggleBulkGroups() {
        const chips = document.querySelectorAll('.bulk-group-chip');
        const anyActive = Array.from(chips).some(c => c.classList.contains('active-green'));
        chips.forEach(c => {
            if(anyActive) c.classList.remove('active-green');
            else c.classList.add('active-green');
        });
    }
    
    function toggleBulkDays() {
        const cbs = document.querySelectorAll('.bulk-day-cb');
        const anyChecked = Array.from(cbs).some(cb => cb.checked);
        cbs.forEach(cb => cb.checked = !anyChecked);
        updateBulkPreview();
    }
    
    function updateBulkPreview() {
        const from = document.getElementById('bulkFrom').value;
        const to = document.getElementById('bulkTo').value;
        const checkedDaysCount = document.querySelectorAll('.bulk-day-cb:checked').length;
        
        const preview = document.getElementById('bulkPreviewText');
        if(from && to) {
            preview.innerText = `${from} to ${to} • ${checkedDaysCount} days selected`;
        } else {
            preview.innerText = `Select a custom date range to preview.`;
        }
    }
    
    function submitBulkUpdate() {
        const from = document.getElementById('bulkFrom').value;
        const to = document.getElementById('bulkTo').value;
        const op = document.getElementById('bulkOperation').value;
        
        let gids = Array.from(document.querySelectorAll('.bulk-group-chip.active-green')).map(cb => cb.dataset.id);
        const days = Array.from(document.querySelectorAll('.bulk-day-cb:checked')).map(cb => parseInt(cb.value));

        if(typeof filterVehicleId !== 'undefined' && filterVehicleId && typeof filterGroupId !== 'undefined') {
            gids = [filterGroupId]; // fallback to current vehicle's group for API requirement
        } else if (gids.length === 0) {
            Swal.fire('Error', 'Please select at least one vehicle group.', 'error');
            return;
        }

        if(!from || !to || !op || days.length === 0) {
            Swal.fire('Error', 'Please fill all fields and check at least one day.', 'error');
            return;
        }
        
        // 1. Close Modal immediately
        closeBulkModal();
        
        // 2. Show Loader in the Ready Badge immediately
        const badge = document.getElementById('statusBadge');
        if (badge) {
            badge.style.background = '#fffbeb';
            badge.style.borderColor = '#fde68a';
            badge.style.color = '#d97706';
            badge.innerHTML = `<svg viewBox="0 0 24 24" class="spin" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg> Updating Bulk Rates...`;
        }

        fetch('{{ route('vendor.availability.bulk-update') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                from_date: from,
                to_date: to,
                operation: op,
                group_ids: gids,
                vehicle_id: typeof filterVehicleId !== 'undefined' ? filterVehicleId : null,
                days: days,
                view_year: currentYear,
                view_month: currentMonth,
                view_groups: typeof filterGroupId !== 'undefined' && filterGroupId ? [filterGroupId] : getSelectedGroups(),
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(res.data) {
                    renderTable(res.data, res.dates);
                    Swal.fire({
                        icon: 'success',
                        title: 'Rates updated successfully.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    fetchRates();
                }
            } else {
                Swal.fire('Error', res.message, 'error');
                if (badge) {
                    badge.style.background = '#fee2e2';
                    badge.style.borderColor = '#fecaca';
                    badge.style.color = '#dc2626';
                    badge.innerHTML = 'Error';
                }
            }
        })
        .catch(err => {
            Swal.fire('Error', 'Failed to update rates', 'error');
            if (badge) {
                badge.style.background = '#fee2e2';
                badge.style.borderColor = '#fecaca';
                badge.style.color = '#dc2626';
                badge.innerHTML = 'Error';
            }
        });
    }

    function copyRates() {
        Swal.fire({
            title: 'Copy Day 1 to All Days?',
            text: "This will copy the price of Day 1 to Days 2-31 for all currently visible rows.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, copy it!'
        }).then(res => {
            if(res.isConfirmed) {
                // Collect day 1 data
                const updates = [];
                const day1Cells = document.querySelectorAll('td.cell-price[data-day="1"]');
                
                day1Cells.forEach(cell => {
                    const price = parseFloat(cell.innerText) || 0;
                    if (price > 0) {
                        updates.push({
                            date: cell.dataset.date,
                            price: price,
                            group_id: cell.dataset.gid,
                            vehicle_id: cell.dataset.vid || null
                        });
                    }
                });
                
                if (updates.length === 0) {
                    Swal.fire('No Data', 'No valid Day 1 prices found to copy (prices must be > 0).', 'info');
                    return;
                }
                
                Swal.fire({
                    title: 'Copying...',
                    text: 'Please wait while we update the prices.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                fetch('{{ route('vendor.availability.bulk-copy-day1') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        updates: updates,
                        _token: '{{ csrf_token() }}'
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        Swal.fire('Success!', 'Day 1 rates copied successfully to Days 2-31.', 'success');
                        fetchRates();
                    } else {
                        Swal.fire('Error', res.message || 'Something went wrong', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Server error occurred.', 'error');
                });
            }
        });
    }

    // Attach listeners to custom date inputs to update preview
    document.getElementById('bulkFrom').addEventListener('change', updateBulkPreview);
    document.getElementById('bulkTo').addEventListener('change', updateBulkPreview);

    // Initial load
    fetchRates();
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let dateRangePicker;
    let bulkDateRangePicker;

    document.addEventListener("DOMContentLoaded", function() {
        dateRangePicker = flatpickr("#dateStart", {
            mode: "range",
            showMonths: 2,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if(selectedDates.length === 1) {
                    document.getElementById('dateStart').value = instance.formatDate(selectedDates[0], "Y-m-d");
                    document.getElementById('dateEnd').value = '';
                }
                if(selectedDates.length === 2) {
                    let start = instance.formatDate(selectedDates[0], "Y-m-d");
                    let end = instance.formatDate(selectedDates[1], "Y-m-d");
                    
                    document.getElementById('dateStart').value = start;
                    document.getElementById('dateEnd').value = end;
                    
                    document.getElementById('dateRangeText').innerText = start + " to " + end;
                    fetchRates();
                }
            }
        });
        
        document.getElementById('dateEnd').addEventListener('click', function() {
            dateRangePicker.open();
        });

        // Bulk Modal Date Range
        bulkDateRangePicker = flatpickr("#bulkFrom", {
            mode: "range",
            showMonths: 2,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if(selectedDates.length === 1) {
                    document.getElementById('bulkFrom').value = instance.formatDate(selectedDates[0], "Y-m-d");
                    document.getElementById('bulkTo').value = '';
                }
                if(selectedDates.length === 2) {
                    let start = instance.formatDate(selectedDates[0], "Y-m-d");
                    let end = instance.formatDate(selectedDates[1], "Y-m-d");
                    
                    document.getElementById('bulkFrom').value = start;
                    document.getElementById('bulkTo').value = end;
                    
                    updateBulkPreview();
                }
            }
        });
        
        document.getElementById('bulkTo').addEventListener('click', function() {
            bulkDateRangePicker.open();
        });
    });

    function clearDateRange() {
        if(typeof dateRangePicker !== 'undefined' && dateRangePicker) {
            dateRangePicker.clear();
        }
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';
        document.getElementById('dateRangeText').innerText = 'Loading...';
        fetchRates();
    }
</script>
