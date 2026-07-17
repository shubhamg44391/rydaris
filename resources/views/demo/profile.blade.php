@extends('demo.layout')

@section('content')
<div style="margin-bottom: 25px;">
    <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">My Profile</h1>
    <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Manage your account details, password and active branch.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
    <!-- Profile Information -->
    <div class="glass-card" style="padding: 30px;">
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff; margin: 0 0 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.05);">Profile Information</h2>
        <form onsubmit="demoProfileSave(event)">
            <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(82,234,210,0.1); border: 2px dashed rgba(82,234,210,0.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-regular fa-image" style="font-size: 1.6rem; color: var(--brand);"></i>
                </div>
                <div style="flex: 1;">
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Company Logo</label>
                    <input type="file" accept="image/*" style="width:100%; padding:10px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Username</label>
                <input type="text" value="rydaris_motors" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Email Address</label>
                <input type="email" value="info@rydaris.com" disabled style="width:100%; padding:12px; background: rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); border-radius:8px; color: var(--text-muted); cursor:not-allowed; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:20px;">
                <div>
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">First Name</label>
                    <input type="text" value="Cynthia" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Last Name</label>
                    <input type="text" value="Meyers" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Middle Name</label>
                <input type="text" value="Keane" style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Company Name</label>
                <input type="text" value="Rydaris Motors" style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Contact Details <span style="color:#ff4d4d;">*</span></label>
                <input type="tel" value="+91 98765 43210" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <h3 style="font-size:1.1rem; font-weight:600; color: var(--brand); margin:30px 0 15px;">Address Information</h3>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Street Address</label>
                <input type="text" value="Ring Road, Near VR Mall" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Landmark</label>
                <input type="text" value="Opposite City Center" style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:20px;">
                <div>
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">City</label>
                    <input type="text" value="Surat" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Pincode</label>
                    <input type="text" value="395007" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Country</label>
                <input type="text" value="India" required style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
            </div>

            <button type="submit" class="xp-btn-save" style="margin-top:15px;">Save Changes</button>
        </form>
    </div>

    <!-- Right column -->
    <div style="display:flex; flex-direction:column; gap:30px;">
        <!-- Change Password -->
        <div class="glass-card" style="padding: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff; margin: 0 0 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.05);">Change Password</h2>
            <form onsubmit="demoProfileSave(event)">
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Current Password</label>
                    <input type="password" required placeholder="Enter current password" style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">New Password</label>
                    <input type="password" required placeholder="Enter new password" style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Confirm New Password</label>
                    <input type="password" required placeholder="Confirm new password" style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; box-sizing:border-box;">
                </div>
                <button type="submit" class="xp-btn-save" style="margin-top:15px;">Update Password</button>
            </form>
        </div>

        <!-- Default Active Branch -->
        <div class="glass-card" style="padding: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff; margin: 0 0 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.05);">Default Active Branch</h2>
            <form onsubmit="demoProfileSave(event)">
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; color: var(--text-muted); font-size:0.875rem;">Select Branch</label>
                    <select style="width:100%; padding:12px; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; outline:none; cursor:pointer; box-sizing:border-box;">
                        <option style="background:#0b1020;">All Branches</option>
                        <option style="background:#0b1020;">Surat</option>
                        <option style="background:#0b1020;">Udhana</option>
                        <option style="background:#0b1020;" selected>Dhili</option>
                    </select>
                </div>
                <button type="submit" class="xp-btn-save">Switch Branch</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function demoProfileSave(e) {
    e.preventDefault();
    Swal.fire({ title: 'Success!', text: 'Record saved successfully.', icon: 'success', timer: 3000, showConfirmButton: false });
}
</script>
@endsection
