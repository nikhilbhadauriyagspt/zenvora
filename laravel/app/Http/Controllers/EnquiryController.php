<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    /**
     * Handle incoming AJAX/Form inquiry submission
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'service' => 'required|string|max:50',
            'org_size' => 'required|string|max:50',
            'timeline' => 'required|string|max:50',
            'message' => 'nullable|string',
        ]);

        $enquiry = Enquiry::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'service' => $validated['service'],
            'org_size' => $validated['org_size'],
            'timeline' => $validated['timeline'],
            'message' => $validated['message'] ?? '',
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your enquiry has been submitted successfully!',
            'enquiry_id' => $enquiry->id
        ]);
    }
}
