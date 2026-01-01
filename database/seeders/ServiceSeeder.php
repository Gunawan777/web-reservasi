<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Import the User model

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get a technician user's ID
        // Assuming UserSeeder creates a user with role 'teknisi'
        $technician = User::where('role', 'teknisi')->first();

        // If no technician is found, you might want to handle this error or create one
        if (!$technician) {
            echo "No technician user found. Skipping ServiceSeeder.\n";
            return;
        }

        $technicianId = $technician->id;

        DB::table('services')->insert([
            [
                'user_id' => $technicianId, // Add user_id
                'category_id' => 1,
                'name' => 'Perbaikan TV',
                'description' => 'Perbaikan semua jenis kerusakan TV.',
                'price' => 150000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $technicianId, // Add user_id
                'category_id' => 1,
                'name' => 'Perbaikan Kulkas',
                'description' => 'Perbaikan semua jenis kerusakan kulkas.',
                'price' => 200000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $technicianId, // Add user_id
                'category_id' => 2,
                'name' => 'Perbaikan Kaki Meja',
                'description' => 'Perbaikan kaki meja yang patah atau goyang.',
                'price' => 75000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $technicianId, // Add user_id
                'category_id' => 3,
                'name' => 'Ganti Oli Motor',
                'description' => 'Ganti oli mesin motor.',
                'price' => 50000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
