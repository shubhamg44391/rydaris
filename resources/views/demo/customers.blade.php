@extends('demo.layout')



@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Customer List</h1>
        <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">
            <i class="fa-solid fa-database" style="color: var(--brand); font-size: 0.8rem; margin-right: 6px;"></i> Demo Database
        </div>
    </div>

    <!-- Customer List Glass Table Card -->
    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700;">Active Customers</h3>
            <button onclick="xpOpen('xpAddCustomerModal')" style="background: var(--brand); color: var(--bg-1); border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;">
                <i class="fa-solid fa-user-plus"></i> Add Customer
            </button>
        </div>

        <div class="demo-table-wrap">
            <table class="demo-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Branch</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td style="font-weight: 700;">Shubham Gupta</td>
                        <td>shubham@gmail.com</td>
                        <td>+91 9876543210</td>
                        <td>Surat</td>
                        <td><span class="badge-status badge-active">Active</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td style="font-weight: 700;">Aarav Mehta</td>
                        <td>aarav.mehta@yahoo.com</td>
                        <td>+91 9123456789</td>
                        <td>Udhana</td>
                        <td><span class="badge-status badge-active">Active</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td style="font-weight: 700;">Pooja Sharma</td>
                        <td>pooja.sharma@outlook.com</td>
                        <td>+91 9988776655</td>
                        <td>Surat</td>
                        <td><span class="badge-status badge-active">Active</span></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td style="font-weight: 700;">Vikram Singh</td>
                        <td>vikram.singh@gmail.com</td>
                        <td>+91 9898989898</td>
                        <td>All Branches</td>
                        <td><span class="badge-status badge-inactive">Inactive</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

{{-- Add Customer Modal --}}
<div id="xpAddCustomerModal" class="xp-overlay">
    <div class="xp-modal">
        <div class="xp-modal-head">
            <span class="xp-modal-title">Add New Customer</span>
            <button class="xp-modal-x" onclick="xpClose('xpAddCustomerModal')">&times;</button>
        </div>
        <form id="xpAddCustomerForm" onsubmit="demoAddCustomer(event)">
            <div class="xp-modal-body">
                <div class="xp-fg">
                    <label>Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. John Doe">
                </div>
                <div class="xp-row">
                    <div class="xp-fg">
                        <label>Email Address</label>
                        <input type="email" name="email" required placeholder="e.g. john@example.com">
                    </div>
                    <div class="xp-fg">
                        <label>Phone Number</label>
                        <input type="text" name="phone" required placeholder="e.g. +91 9988776655">
                    </div>
                </div>
                <div class="xp-row">
                    <div class="xp-fg">
                        <label>Branch</label>
                        <select name="branch">
                            <option value="Surat">Surat</option>
                            <option value="Udhana">Udhana</option>
                            <option value="All Branches">All Branches</option>
                        </select>
                    </div>
                    <div class="xp-fg">
                        <label>Status</label>
                        <select name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="xp-modal-foot">
                <button type="button" class="xp-btn-cancel" onclick="xpClose('xpAddCustomerModal')">Cancel</button>
                <button type="submit" class="xp-btn-save">Add Customer</button>
            </div>
        </form>
    </div>
</div>

<script>
    let customerCount = 4;
    function demoAddCustomer(e) {
        e.preventDefault();
        const form = e.target;
        const name = form.name.value;
        const email = form.email.value;
        const phone = form.phone.value;
        const branch = form.branch.value;
        const status = form.status.value;

        customerCount++;

        const tbody = document.querySelector('.demo-table tbody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${customerCount}</td>
            <td style="font-weight: 700;">${name}</td>
            <td>${email}</td>
            <td>${phone}</td>
            <td>${branch}</td>
            <td><span class="badge-status ${status === 'Active' ? 'badge-active' : 'badge-inactive'}">${status}</span></td>
        `;
        tbody.appendChild(tr);

        // Reset form and close modal
        form.reset();
        xpClose('xpAddCustomerModal');

        Swal.fire({
            icon: 'success',
            title: 'Customer Added!',
            text: 'New customer has been successfully added to the local demo list (Not saved to database).',
            confirmButtonColor: '#52ead2',
            confirmButtonText: 'OK'
        });
    }
</script>
@endsection
