<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use App\Models\Setting;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Authenticate admin user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt login using 'username' instead of 'email'
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Admin dashboard home
     */
    public function dashboard()
    {
        $totalEnquiries = Enquiry::count();
        $pendingEnquiries = Enquiry::where('status', 'Pending')->count();
        $processedEnquiries = Enquiry::where('status', 'Processed')->count();
        $recentEnquiries = Enquiry::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalEnquiries', 'pendingEnquiries', 'processedEnquiries', 'recentEnquiries'));
    }

    /**
     * Logout admin user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Show settings manager
     */
    public function settings()
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update global website settings
     */
    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value ?? '']
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Show homepage CMS editor
     */
    public function homepage()
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.homepage', compact('settings'));
    }

    /**
     * Update homepage dynamic content
     */
    public function updateHomepage(Request $request)
    {
        return $this->updateSettings($request);
    }

    /**
     * Enquiries list management
     */
    public function enquiries()
    {
        $enquiries = Enquiry::latest()->paginate(15);
        return view('admin.enquiries', compact('enquiries'));
    }

    /**
     * Update status of Enquiry
     */
    public function updateEnquiryStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Processed,Canceled'
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->status = $request->status;
        $enquiry->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }

    /**
     * Export all enquiries as CSV
     */
    public function exportEnquiries()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=enquiries_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $enquiries = Enquiry::all();

        $callback = function() use ($enquiries) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Phone', 'Email', 'Service', 'Org Size', 'Timeline', 'Message', 'Status', 'Submitted At']);

            foreach ($enquiries as $enquiry) {
                fputcsv($file, [
                    $enquiry->id,
                    $enquiry->name,
                    $enquiry->phone,
                    $enquiry->email,
                    $enquiry->service,
                    $enquiry->org_size,
                    $enquiry->timeline,
                    $enquiry->message,
                    $enquiry->status,
                    $enquiry->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get unread notifications
     */
    public function getPendingNotifications()
    {
        $pending = Enquiry::where('status', 'Pending')->latest()->take(5)->get();
        return response()->json([
            'count' => $pending->count(),
            'notifications' => $pending
        ]);
    }

    /**
     * Clear all notifications (Mark as Processed)
     */
    public function clearNotifications()
    {
        Enquiry::where('status', 'Pending')->update(['status' => 'Processed']);
        return response()->json(['success' => true]);
    }
}
