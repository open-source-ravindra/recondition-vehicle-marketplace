<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\VehicleTransfer;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Baba Admin',
            'email' => 'admin@babarecondition.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_ADMIN,
            'phone' => '9841234567',
            'address' => 'Dhangadhi-8, Chyamsar Road, Kailali',
        ]);

        // Create Staff User
        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@babarecondition.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_STAFF,
            'phone' => '9847654321',
        ]);

        // Create Regular User (for testing)
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@babarecondition.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_USER,
            'phone' => '9841111111',
        ]);

        // Create Buyer Customer
        $buyer = Customer::create([
            'name' => 'राम बहादुर थापा',
            'date_of_birth' => '1990-05-15',
            'citizenship_number' => '12345-6789',
            'father_name' => 'हरि बहादुर थापा',
            'grandfather_name' => 'बहादुर थापा',
            'phone' => '9841234567',
            'ward_no' => '8',
            'municipality_type' => 'municipality',
            'address' => 'धनगढी-८, च्याम्सार रोड',
            'customer_type' => 'buyer',
            // 'email' => 'ram.thapa@example.com',
        ]);

        // Create Seller Customer
        $seller = Customer::create([
            'name' => 'श्याम प्रसाद शर्मा',
            'date_of_birth' => '1985-08-20',
            'citizenship_number' => '98765-4321',
            'father_name' => 'हरी प्रसाद शर्मा',
            'grandfather_name' => 'प्रसाद शर्मा',
            'phone' => '9847654321',
            'ward_no' => '5',
            'municipality_type' => 'sub_metropolitan_city',
            'address' => 'कैलाली, नेपालगंज',
            'customer_type' => 'seller',
            'email' => 'shyam.sharma@example.com',
        ]);

        // Create Witness Customer
        $witness = Customer::create([
            'name' => 'हरी प्रसाद कोईराला',
            'citizenship_number' => '54321-9876',
            'father_name' => 'राम प्रसाद कोईराला',
            'grandfather_name' => 'प्रसाद कोईराला',
            'phone' => '9842223333',
            'ward_no' => '3',
            'municipality_type' => 'rural_municipality',
            'address' => 'धनगढी-३',
            'customer_type' => 'witness',
        ]);

        // Create Vehicle 1 (Bike - Available)
        $vehicle1 = Vehicle::create([
            'name' => 'Hero Splendor Plus',
            'vehicle_type' => 'bike',
            'cc' => 100,
            'manufacture_year' => 2020,
            'condition' => 'excellent',
            'color' => 'Black',
            'engine_number' => 'ENG123456789',
            'chassis_number' => 'CHS987654321',
            'purchase_price' => 80000.00,
            'selling_price' => 95000.00,
            'registered_name' => 'श्याम प्रसाद शर्मा',
            'transferred_by' => 'Baba Recondition House',
            'purchase_date' => '2023-01-15',
            'status' => 'available',
            'description' => 'Good condition, single owner, 15000 km run',
            'mileage' => 15000,
            'fuel_type' => 'petrol',
        ]);

        // Create Vehicle 2 (Bike - Available)
        $vehicle2 = Vehicle::create([
            'name' => 'Honda CB Hornet 160R',
            'vehicle_type' => 'bike',
            'cc' => 160,
            'manufacture_year' => 2021,
            'condition' => 'good',
            'color' => 'Red',
            'engine_number' => 'ENG987654321',
            'chassis_number' => 'CHS123456789',
            'purchase_price' => 150000.00,
            'selling_price' => 180000.00,
            'registered_name' => 'राम बहादुर थापा',
            'transferred_by' => 'Baba Recondition House',
            'purchase_date' => '2023-03-10',
            'status' => 'available',
            'description' => '2nd owner, well maintained',
            'mileage' => 25000,
            'fuel_type' => 'petrol',
        ]);

        // Create Vehicle 3 (Scooter - Sold)
        $vehicle3 = Vehicle::create([
            'name' => 'TVS Jupiter',
            'vehicle_type' => 'scooter',
            'cc' => 110,
            'manufacture_year' => 2019,
            'condition' => 'used',
            'color' => 'Blue',
            'engine_number' => 'ENG555666777',
            'chassis_number' => 'CHS888999000',
            'purchase_price' => 70000.00,
            'selling_price' => 85000.00,
            'registered_name' => 'बाबा रिकन्डिसन हाउस',
            'transferred_by' => 'Previous Owner',
            'purchase_date' => '2023-02-20',
            'status' => 'sold',
            'description' => 'Normal wear and tear',
            'mileage' => 30000,
            'fuel_type' => 'petrol',
        ]);

        // Create Completed Vehicle Transfer
        $transfer1 = VehicleTransfer::create([
            'transfer_number' => 'TRF-' . date('Ymd') . '-0001',
            'vehicle_id' => $vehicle3->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'witness_id' => $witness->id,
            'created_by' => $admin->id,
            'notes' => 'Completed transfer with all documents',
            'expenses_borne_by_buyer' => true,
            'transfer_date' => now()->subDays(10),
            'status' => 'completed',
            'registration_fee' => 1500.00,
            'tax_amount' => 2500.00,
            'commission' => 5000.00,
            'other_expenses' => 1000.00,
            'total_expenses' => 10000.00,
            'bluebook_received' => true,
            'insurance_transferred' => true,
            'key_handover' => true,
            'documents_handover' => true,
        ]);

        // Create Payment for Transfer 1
        $payment1 = Payment::create([
            'transfer_id' => $transfer1->id,
            'total_price' => 85000.00,
            'amount_paid' => 85000.00,
            'amount_received' => 85000.00,
            'payment_method' => 'cash',
            'payment_type' => 'full',
            'payment_date' => now()->subDays(10),
            'payment_status' => 'paid',
            'received_by' => $staff->id,
            'payment_notes' => 'Full payment in cash',
        ]);

        // Create Pending Vehicle Transfer
        $transfer2 = VehicleTransfer::create([
            'transfer_number' => 'TRF-' . date('Ymd') . '-0002',
            'vehicle_id' => $vehicle1->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'created_by' => $staff->id,
            'notes' => 'Pending payment',
            'expenses_borne_by_buyer' => true,
            'transfer_date' => now(),
            'status' => 'pending',
        ]);

        // Create Partial Payment for Transfer 2
        $payment2 = Payment::create([
            'transfer_id' => $transfer2->id,
            'total_price' => 95000.00,
            'amount_paid' => 50000.00,
            'amount_received' => 50000.00,
            'payment_method' => 'bank_transfer',
            'payment_type' => 'advance',
            'payment_date' => now(),
            'payment_status' => 'partial',
            'received_by' => $staff->id,
            'payment_notes' => 'Advance payment via bank transfer',
            'bank_name' => 'Nabil Bank',
            'online_transaction_id' => 'TRX' . rand(100000, 999999),
        ]);

        // Update vehicle status for sold vehicle
        $vehicle3->update(['status' => 'sold']);

        // Create more sample data if in local environment
        if (app()->environment('local')) {
            \App\Models\Customer::factory(10)->create();
            \App\Models\Vehicle::factory(8)->create();

            // Create additional transfers
            foreach (Vehicle::where('status', 'available')->take(3)->get() as $vehicle) {
                $transfer = VehicleTransfer::create([
                    'transfer_number' => VehicleTransfer::generateTransferNumber(),
                    'vehicle_id' => $vehicle->id,
                    'buyer_id' => Customer::where('customer_type', 'buyer')->inRandomOrder()->first()->id,
                    'seller_id' => Customer::where('customer_type', 'seller')->inRandomOrder()->first()->id,
                    'created_by' => $staff->id,
                    'transfer_date' => now()->subDays(rand(1, 30)),
                    'status' => 'completed',
                ]);

                Payment::create([
                    'transfer_id' => $transfer->id,
                    'total_price' => $vehicle->selling_price,
                    'amount_paid' => $vehicle->selling_price,
                    'amount_received' => $vehicle->selling_price,
                    'payment_method' => ['cash', 'bank_transfer'][rand(0, 1)],
                    'payment_date' => now()->subDays(rand(1, 30)),
                    'payment_status' => 'paid',
                    'received_by' => $staff->id,
                ]);

                $vehicle->update(['status' => 'sold']);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@babarecondition.com / password123');
        $this->command->info('Staff Login: staff@babarecondition.com / password123');
        $this->command->info('User Login: user@babarecondition.com / password123');
    }
}
