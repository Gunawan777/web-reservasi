<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;

class TechnicianServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming 'Teknisi Uji' has ID 2
        $teknisi = User::where('email', 'teknisi@example.com')->first();

        // Assuming Service IDs: 1 for 'Perbaikan TV', 2 for 'Perbaikan Kulkas'
        $service1 = Service::find(1);
        $service2 = Service::find(2);

        if ($teknisi && $service1) {
            $service1->user_id = $teknisi->id;
            $service1->save();
        }
        if ($teknisi && $service2) {
            $service2->user_id = $teknisi->id;
            $service2->save();
        }
    }
}
