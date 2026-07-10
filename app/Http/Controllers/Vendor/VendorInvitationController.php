<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInvitation;
use App\Models\User;
use App\Models\VendorSmtpSetting;
use App\Mail\InviteUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VendorInvitationController extends Controller
{
    /**
     * Display a listing of invitations.
     */
    public function index()
    {
        $vendorId = auth()->id();
        
        $invitations = UserInvitation::where('vendor_id', $vendorId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalCount = UserInvitation::where('vendor_id', $vendorId)->count();
        $acceptedCount = UserInvitation::where('vendor_id', $vendorId)->where('status', 'accepted')->count();
        $pendingCount = UserInvitation::where('vendor_id', $vendorId)->where('status', 'pending')->count();

        return view('vendor.invitations.index', compact('invitations', 'totalCount', 'acceptedCount', 'pendingCount'));
    }

    /**
     * Show the form for creating a new invitation.
     */
    public function create()
    {
        return view('vendor.invitations.create');
    }

    /**
     * Store a newly created invitation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'name'  => 'nullable|string|max:255',
        ], [
            'email.unique' => 'A registered user already exists with this email address.',
        ]);

        // Check if there is already a pending invitation for this email from this vendor
        $existing = UserInvitation::where('vendor_id', auth()->id())
            ->where('email', $request->email)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->withInput()->withErrors(['email' => 'A pending invitation has already been sent to this email address.']);
        }

        // Check if vendor has reached user capacity
        $vendor = auth()->user();
        $vendor->load(['subscription' => function($q) {
            $q->where('status', 'active')
              ->where('starts_at', '<=', now())
              ->where('ends_at', '>=', now());
        }, 'subscription.package']);

        if ($vendor->subscription && $vendor->subscription->package) {
            $maxUsers = $vendor->subscription->package->no_of_users;
            if (!empty($maxUsers) && $maxUsers != 'Unlimited') {
                $maxUsers = (int) $maxUsers;
                $currentUsers = User::where('vendor_id', $vendor->id)->where('role', 'user')->count();
                
                if ($currentUsers >= $maxUsers) {
                    return back()->withInput()->withErrors(['email' => 'You have reached your maximum user capacity based on your current plan. Upgrade your plan to invite more users.']);
                }
            }
        }

        // Create Invitation
        $invitation = UserInvitation::create([
            'vendor_id' => auth()->id(),
            'email'     => $request->email,
            'name'      => $request->name,
            'token'     => Str::random(40),
            'status'    => 'pending',
        ]);

        // Set Mail Configuration and send invitation
        VendorSmtpSetting::setMailConfig(auth()->id());
        
        try {
            Mail::to($invitation->email)->send(new InviteUserMail($invitation));
        } catch (\Exception $e) {
            // If mail fails, delete invitation and return error
            $invitation->delete();
            return back()->withInput()->withErrors(['email' => 'Failed to send invitation email: ' . $e->getMessage()]);
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation sent successfully.');
    }

    /**
     * Show the form for editing the specified invitation.
     */
    public function edit($id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        return view('vendor.invitations.edit', compact('invitation'));
    }

    /**
     * Update the specified invitation in storage.
     */
    public function update(Request $request, $id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'name'  => 'nullable|string|max:255',
        ], [
            'email.unique' => 'A registered user already exists with this email address.',
        ]);

        $oldEmail = $invitation->email;
        
        $invitation->update([
            'email' => $request->email,
            'name'  => $request->name,
        ]);

        // If the email has changed, we should automatically resend the invitation
        if ($oldEmail !== $request->email) {
            VendorSmtpSetting::setMailConfig(auth()->id());
            try {
                Mail::to($invitation->email)->send(new InviteUserMail($invitation));
            } catch (\Exception $e) {
                return redirect()->route('vendor.invitations.index')->with('warning', 'Invitation updated, but email resend failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation updated successfully.');
    }

    /**
     * Remove the specified invitation from storage.
     */
    public function destroy($id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->firstOrFail();

        $invitation->delete();

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation deleted successfully.');
    }

    /**
     * Resend the specified invitation.
     */
    public function resend($id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        VendorSmtpSetting::setMailConfig(auth()->id());

        try {
            Mail::to($invitation->email)->send(new InviteUserMail($invitation));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend invitation email: ' . $e->getMessage());
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation email resent successfully.');
    }
}
