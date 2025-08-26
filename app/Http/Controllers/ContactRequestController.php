<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactRequestController extends Controller
{
            // Public method for sending application
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:contact,test_drive,quote,apply_online',
            'car_id' => 'nullable|exists:cars,id',
        ]);

        try {
            $contactRequest = ContactRequest::create($data);
            
            // Here you can add email notification sending
            // Mail::to('admin@example.com')->send(new ContactRequestNotification($contactRequest));
            
            return response()->json([
                'success' => true,
                'message' => 'Your application has been successfully sent! We will contact you soon.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the application. Please try again later.'
            ], 500);
        }
    }

            // Admin method for viewing all applications
    public function index()
    {
        $requests = ContactRequest::with('car')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.requests', compact('requests'));
    }

            // Admin method for viewing specific application
    public function show($id)
    {
        $request = ContactRequest::with('car')->findOrFail($id);
        return view('admin.request_show', compact('request'));
    }

            // Admin method for updating application status
    public function updateStatus(Request $request, $id)
    {
        $contactRequest = ContactRequest::findOrFail($id);
        
        $data = $request->validate([
            'status' => 'required|in:new,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $contactRequest->update($data);

        if ($data['status'] === 'completed') {
            $contactRequest->markAsCompleted();
        }

        return response()->json([
            'success' => true,
                            'message' => 'Application status updated'
        ]);
    }

            // Admin method for deleting application
    public function destroy($id)
    {
        $contactRequest = ContactRequest::findOrFail($id);
        $contactRequest->delete();

        return redirect()->route('admin.requests')->with('success', 'Application deleted');
    }

            // Method for getting application statistics
    public function getStats()
    {
        $stats = [
            'total' => ContactRequest::count(),
            'new' => ContactRequest::new()->count(),
            'in_progress' => ContactRequest::inProgress()->count(),
            'completed' => ContactRequest::completed()->count(),
            'by_type' => [
                'contact' => ContactRequest::byType('contact')->count(),
                'test_drive' => ContactRequest::byType('test_drive')->count(),
                'quote' => ContactRequest::byType('quote')->count(),
                'apply_online' => ContactRequest::byType('apply_online')->count(),
            ]
        ];

        return response()->json($stats);
    }
}
