<?php

namespace Database\Seeders;

use App\Models\ContactRequest;
use App\Models\Car;
use Illuminate\Database\Seeder;

class ContactRequestSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        
        if ($cars->count() > 0) {
            // Create test requests
            ContactRequest::create([
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'phone' => '+1 (555) 123-4567',
                'subject' => 'Interest in BMW X5',
                'message' => 'Hello! I am interested in BMW X5 2022. I would like to know more information about the car condition and test drive availability.',
                'type' => 'test_drive',
                'status' => 'new',
                'car_id' => $cars->first()->id,
            ]);

            ContactRequest::create([
                'name' => 'Maria Johnson',
                'email' => 'maria@example.com',
                'phone' => '+1 (555) 987-6543',
                'subject' => 'Price request for Mercedes',
                'message' => 'Good day! I am interested in Mercedes-Benz C-Class. Can you provide information about price and purchase conditions?',
                'type' => 'quote',
                'status' => 'in_progress',
                'car_id' => $cars->skip(1)->first()->id,
            ]);

            ContactRequest::create([
                'name' => 'Alex Brown',
                'email' => 'alex@example.com',
                'phone' => '+1 (555) 456-7890',
                'subject' => 'General question',
                'message' => 'Hello! I would like to know if you have cars on credit and what are the conditions?',
                'type' => 'contact',
                'status' => 'completed',
                'car_id' => null,
                'admin_notes' => 'Client received information about credit programs',
                'processed_at' => now(),
            ]);

            ContactRequest::create([
                'name' => 'Elena Wilson',
                'email' => 'elena@example.com',
                'phone' => '+1 (555) 789-0123',
                'subject' => 'Online credit application',
                'message' => 'I want to apply for a loan to buy a car. My income: $5000/month, good credit history.',
                'type' => 'apply_online',
                'status' => 'new',
                'car_id' => $cars->skip(2)->first()->id,
            ]);
        }
    }
}
