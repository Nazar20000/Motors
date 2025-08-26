<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use App\Services\CrmLeadExporter;
use App\Jobs\ExportApplicationToCrm;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate data
            $validatedData = $request->validate([
                'buyer_type' => 'required|in:buyer,co-buyer',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'cell_phone' => 'required|string|max:20',
                'home_phone' => 'nullable|string|max:20',
                'date_of_birth' => 'required',
                'ssn' => 'required|string|max:11',
                'driver_license' => 'nullable|string|max:255',
                'driver_license_state' => 'nullable|string|max:2',
                'license_issue_date' => 'nullable',
                'license_expiry_date' => 'nullable',
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:2',
                'zip_code' => 'required|string|max:10',
                'housing_type' => 'required|in:own,rent,live-with-family,other',
                'monthly_rent' => 'required|numeric|min:0',
                'years_at_address' => 'required|string',
                'months_at_address' => 'nullable|string',
                'employer_name' => 'required|string|max:255',
                'job_title' => 'required|string|max:255',
                'employer_phone' => 'required|string|max:20',
                'monthly_income' => 'required|numeric|min:0',
                'years_at_job' => 'required|string',
                'months_at_job' => 'nullable|string',
                'previous_addresses' => 'nullable|array',
                'previous_addresses.*.street_address' => 'required_with:previous_addresses|string|max:255',
                'previous_addresses.*.city' => 'required_with:previous_addresses|string|max:255',
                'previous_addresses.*.state' => 'required_with:previous_addresses|string|max:2',
                'previous_addresses.*.zip_code' => 'required_with:previous_addresses|string|max:10',
                'previous_addresses.*.years' => 'nullable|string',
                'previous_addresses.*.months' => 'nullable|string',
                'previous_employments' => 'nullable|array',
                'previous_employments.*.employer_name' => 'required_with:previous_employments|string|max:255',
                'previous_employments.*.job_title' => 'required_with:previous_employments|string|max:255',
                'previous_employments.*.employer_phone' => 'required_with:previous_employments|string|max:20',
                'previous_employments.*.monthly_income' => 'nullable|numeric|min:0',
                'previous_employments.*.years' => 'nullable|string',
                'previous_employments.*.months' => 'nullable|string',
                'car_id' => 'nullable|integer|exists:cars,id',
                'stock_number' => 'nullable|string|max:255',
                'vehicle_year' => 'nullable|string|max:4',
                'vehicle_make' => 'nullable|string|max:255',
                'vehicle_model' => 'nullable|string|max:255',
                'vehicle_price' => 'nullable|numeric|min:0',
                'down_payment' => 'nullable|numeric|min:0',
                'exterior_color' => 'nullable|string|max:255',
                'interior_color' => 'nullable|string|max:255',
                'has_trade_in' => 'nullable|in:0,1',
                'trade_vin' => 'nullable|string|max:17',
                'trade_mileage' => 'nullable|string|max:255',
                'trade_year' => 'nullable|string|max:4',
                'trade_make' => 'nullable|string|max:255',
                'trade_model' => 'nullable|string|max:255',
                'accepts_terms' => 'required|in:0,1'
            ]);

            // Normalize US dates to Y-m-d if provided as MM/DD/YYYY
            foreach (['date_of_birth','license_issue_date','license_expiry_date'] as $dateField) {
                if (!empty($validatedData[$dateField]) && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $validatedData[$dateField])) {
                    [$mm,$dd,$yyyy] = explode('/', $validatedData[$dateField]);
                    $validatedData[$dateField] = sprintf('%04d-%02d-%02d', (int)$yyyy, (int)$mm, (int)$dd);
                }
            }

            // Clean SSN from dashes
            $validatedData['ssn'] = str_replace('-', '', $validatedData['ssn']);



            // Clean down payment from dollar sign and commas if it's a string
            if (isset($validatedData['down_payment']) && is_string($validatedData['down_payment'])) {
                $validatedData['down_payment'] = str_replace(['$', ','], '', $validatedData['down_payment']);
            }

            // Convert string boolean values to actual booleans
            $hasTradeIn = isset($validatedData['has_trade_in']) && (bool) $validatedData['has_trade_in'];
            $validatedData['has_trade_in'] = $hasTradeIn;
            if (isset($validatedData['accepts_terms'])) {
                $validatedData['accepts_terms'] = (bool) $validatedData['accepts_terms'];
            }

            // Validate trade-in fields if has_trade_in is true
            if ($hasTradeIn) {
                $tradeInValidation = $request->validate([
                    'trade_vin' => 'required|string|max:17',
                    'trade_mileage' => 'required|string|max:255',
                    'trade_year' => 'required|string|max:4',
                    'trade_make' => 'required|string|max:255',
                    'trade_model' => 'required|string|max:255',
                ]);
                
                // Merge the validated trade-in data
                $validatedData = array_merge($validatedData, $tradeInValidation);
            }

            // Create application
            $application = Application::create($validatedData);

            Log::info('New application submitted', [
                'application_id' => $application->id,
                'buyer_name' => $application->full_name,
                'email' => $application->email
            ]);

            // Queue export to CRM (non-blocking, retries on failure)
            ExportApplicationToCrm::dispatch($application->id);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'application_id' => $application->id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Application submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your application. Please try again.'
            ], 500);
        }
    }

    public function index()
    {
        $applications = Application::with('car.brand', 'car.carModel')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.applications', compact('applications'));
    }

    public function show($id)
    {
        $application = Application::with('car.brand', 'car.carModel', 'car.bodyType', 'car.color', 'car.transmission')->findOrFail($id);
        return view('admin.application-details', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected,in_review',
            'notes' => 'nullable|string'
        ]);

        $application->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully'
        ]);
    }

    public function updateNotes(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        $validatedData = $request->validate([
            'notes' => 'nullable|string'
        ]);

        $application->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully'
        ]);
    }
}
