<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_categories')->insert([
            [
                'name' => 'Elektronik',
                'description' => 'Perbaikan alat-alat elektronik seperti TV, kulkas, AC, dll.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perabotan',
                'description' => 'Perbaikan perabotan rumah tangga seperti kursi, meja, lemari, dll.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kendaraan',
                'description' => 'Perbaikan kendaraan bermotor seperti mobil dan motor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
