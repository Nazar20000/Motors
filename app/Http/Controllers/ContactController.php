<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'contactPreference' => 'array',
                'contactPreference.*' => 'in:phone,email,sms',
                'message' => 'required|string|max:1024',
                'acceptTerms' => 'required|accepted'
            ]);

            // Log the contact request
            Log::info('New contact form submission', [
                'name' => $validatedData['firstName'] . ' ' . $validatedData['lastName'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'preferences' => $validatedData['contactPreference'] ?? [],
                'message_length' => strlen($validatedData['message'])
            ]);

            // Here you could send an email notification
            // Mail::to('danijela13@gmail.com')->send(new ContactFormMail($validatedData));

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your form and try again.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending your message. Please try again.'
            ], 500);
        }
    }
} 