<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@cibeureum.test'
            ],
            [
                'name' => 'Admin IT Cibeureum',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'staf@cibeureum.test'
            ],
            [
                'name' => 'Staf Cibeureum',
                'password' => Hash::make('password'),
                'role' => 'staf',
            ]
        );


        $ruangPelayanan = Room::firstOrCreate([
            'name' => 'Ruang Pelayanan'
        ]);

        $ruangSekretariat = Room::firstOrCreate([
            'name' => 'Ruang Sekretariat'
        ]);

        $ruangKeuangan = Room::firstOrCreate([
            'name' => 'Ruang Keuangan'
        ]);


        Device::firstOrCreate(
            [
                'inventory_code' => 'PC-001'
            ],
            [
                'room_id' => $ruangSekretariat->id,
                'name' => 'Komputer Sekretariat 01',
                'category' => 'Komputer',
                'description' => 'Komputer untuk kebutuhan administrasi.',
            ]
        );


        Device::firstOrCreate(
            [
                'inventory_code' => 'PR-001'
            ],
            [
                'room_id' => $ruangPelayanan->id,
                'name' => 'Printer Pelayanan 01',
                'category' => 'Printer',
                'description' => 'Printer untuk kebutuhan pelayanan.',
            ]
        );
    }
}
