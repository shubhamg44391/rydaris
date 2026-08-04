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
    

    public function index(Request $request)
    {
        $vendorId = auth()->id();
        $query = UserInvitation::where('vendor_id', $vendorId);

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        $invitations = $query->orderBy('created_at', 'desc')->paginate(15);

        $totalCount = UserInvitation::where('vendor_id', $vendorId)->count();
        $acceptedCount = UserInvitation::where('vendor_id', $vendorId)->where('status', 'accepted')->count();
        $pendingCount = UserInvitation::where('vendor_id', $vendorId)->where('status', 'pending')->count();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('vendor.invitations.index', compact('invitations', 'totalCount', 'acceptedCount', 'pendingCount'))->renderSections()['invitations_table_section'] ?? '',
                'totalCount' => $totalCount,
                'acceptedCount' => $acceptedCount,
                'pendingCount' => $pendingCount
            ]);
        }

        return view('vendor.invitations.index', compact('invitations', 'totalCount', 'acceptedCount', 'pendingCount'));
    }

    

    public function create()
    {
        if (!auth()->user()->canAddInvitation()) {
            return redirect()->route('vendor.invitations.index')->with('error', 'You have reached your maximum invitation capacity based on your current plan. Upgrade your plan to send more invitations.');
        }
        return view('vendor.invitations.create');
    }

    

    public function store(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        try {
            $request->validate([
                'email' => 'required|email|max:255|unique:users,email',
                'name'  => 'nullable|string|max:255',
            ], [
                'email.unique' => 'A registered user already exists with this email address.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
                ], 422);
            }
            throw $e;
        }

        $existing = UserInvitation::where('vendor_id', auth()->id())
            ->where('email', $request->email)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            $msg = 'A pending invitation has already been sent to this email address.';
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withInput()->withErrors(['email' => $msg]);
        }

        $vendor = auth()->user();
        if (!$vendor->canAddInvitation()) {
            $msg = 'You have reached your maximum invitation capacity based on your current plan. Upgrade your plan to send more invitations.';
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withInput()->withErrors(['email' => $msg]);
        }

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
                    $msg = 'You have reached your maximum user capacity based on your current plan. Upgrade your plan to invite more users.';
                    if ($isAjax) {
                        return response()->json(['success' => false, 'message' => $msg], 422);
                    }
                    return back()->withInput()->withErrors(['email' => $msg]);
                }
            }
        }

        $invitation = UserInvitation::create([
            'vendor_id' => auth()->id(),
            'email'     => $request->email,
            'name'      => $request->name,
            'token'     => Str::random(40),
            'status'    => 'pending',
        ]);

        VendorSmtpSetting::setMailConfig(auth()->id());
        
        try {
            Mail::to($invitation->email)->send(new InviteUserMail($invitation));
        } catch (\Exception $e) {
            $invitation->delete();
            $msg = 'Failed to send invitation email: ' . $e->getMessage();
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withInput()->withErrors(['email' => $msg]);
        }

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Invitation sent successfully.'
            ]);
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation sent successfully.');
    }

    public function edit(Request $request, $id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'invitation' => $invitation
            ]);
        }

        return view('vendor.invitations.edit', compact('invitation'));
    }

    public function update(Request $request, $id)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        try {
            $request->validate([
                'email' => 'required|email|max:255|unique:users,email,' . $invitation->id,
                'name'  => 'nullable|string|max:255',
            ], [
                'email.unique' => 'A registered user already exists with this email address.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
                ], 422);
            }
            throw $e;
        }

        $oldEmail = $invitation->email;
        
        $invitation->update([
            'email' => $request->email,
            'name'  => $request->name,
        ]);

        if ($oldEmail !== $request->email) {
            VendorSmtpSetting::setMailConfig(auth()->id());
            try {
                Mail::to($invitation->email)->send(new InviteUserMail($invitation));
            } catch (\Exception $e) {
                if ($isAjax) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Invitation updated, but email resend failed: ' . $e->getMessage()
                    ]);
                }
                return redirect()->route('vendor.invitations.index')->with('warning', 'Invitation updated, but email resend failed: ' . $e->getMessage());
            }
        }

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Invitation updated successfully.'
            ]);
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation updated successfully.');
    }

    

    public function destroy(Request $request, $id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->firstOrFail();

        $invitation->delete();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Invitation deleted successfully.'
            ]);
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation deleted successfully.');
    }

    public function resend(Request $request, $id)
    {
        $invitation = UserInvitation::where('id', $id)
            ->where('vendor_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        VendorSmtpSetting::setMailConfig(auth()->id());

        try {
            Mail::to($invitation->email)->send(new InviteUserMail($invitation));
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to resend invitation email: ' . $e->getMessage()
                ], 422);
            }
            return back()->with('error', 'Failed to resend invitation email: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Invitation email resent successfully.'
            ]);
        }

        return redirect()->route('vendor.invitations.index')->with('success', 'Invitation email resent successfully.');
    }
}
