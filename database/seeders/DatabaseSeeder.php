<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Consultant;
use App\Models\Service;
use App\Models\Availability;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Consultants
        $consultantsData = [
            [
                'name' => 'Dr. Alice Smith',
                'email' => 'alice@example.com',
                'specialization' => 'Frontend Architecture',
                'bio' => 'Expert in React, Vue, and modern frontend ecosystems.',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'specialization' => 'Cloud Infrastructure',
                'bio' => 'AWS Certified Solutions Architect.',
            ],
            [
                'name' => 'Carol Williams',
                'email' => 'carol@example.com',
                'specialization' => 'Database Optimization',
                'bio' => 'MySQL and PostgreSQL performance tuning specialist.',
            ],
        ];

        foreach ($consultantsData as $cData) {
            $user = User::create([
                'name' => $cData['name'],
                'email' => $cData['email'],
                'password' => Hash::make('password'),
                'role' => 'consultant',
            ]);

            $consultant = Consultant::create([
                'user_id' => $user->id,
                'specialization' => $cData['specialization'],
                'experience_years' => rand(5, 15),
                'session_price' => rand(100, 300),
                'office_location' => 'Virtual / HQ',
                'bio' => $cData['bio']
            ]);

            // Add Services
            Service::create([
                'consultant_id' => $consultant->id,
                'name' => 'Initial Consultation',
                'duration' => 30,
            ]);
            Service::create([
                'consultant_id' => $consultant->id,
                'name' => 'Deep Dive Session',
                'duration' => 60,
            ]);

            // Add Availabilities (Mon-Fri, 9 AM to 5 PM)
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            foreach ($days as $day) {
                Availability::create([
                    'consultant_id' => $consultant->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                ]);
            }
        }

        // 3. Clients
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Client User $i",
                'email' => "client$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);
        }
    }
}
