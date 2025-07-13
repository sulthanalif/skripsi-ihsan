<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wargas = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'nik' => '3171234567890001',
                'kk' => '3171234567890002',
                'birth_place' => 'Jakarta',
                'birth_date' => '1990-01-15',
                'gender' => 'Laki-laki',
                'nationality' => 'Indonesia',
                'religion' => 'Islam',
                'marital_status' => 'Menikah',
                'occupation' => 'Software Engineer',
                'address_ktp' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'address_domisili' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'nik' => '3171234567890003',
                'kk' => '3171234567890004',
                'birth_place' => 'Surabaya',
                'birth_date' => '1992-03-20',
                'gender' => 'Perempuan',
                'nationality' => 'Indonesia',
                'religion' => 'Kristen Protestan',
                'marital_status' => 'Belum Menikah',
                'occupation' => 'Teacher',
                'address_ktp' => 'Jl. Pahlawan No. 45, Surabaya',
                'address_domisili' => 'Jl. Pahlawan No. 45, Surabaya',
            ],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
                'nik' => '3171234567890005',
                'kk' => '3171234567890006',
                'birth_place' => 'Bandung',
                'birth_date' => '1988-07-10',
                'gender' => 'Laki-laki',
                'nationality' => 'Indonesia',
                'religion' => 'Islam',
                'marital_status' => 'Menikah',
                'occupation' => 'Entrepreneur',
                'address_ktp' => 'Jl. Asia Afrika No. 78, Bandung',
                'address_domisili' => 'Jl. Asia Afrika No. 78, Bandung',
            ],
            [
                'name' => 'Maria Susanti',
                'email' => 'maria@example.com',
                'password' => Hash::make('password'),
                'nik' => '3171234567890007',
                'kk' => '3171234567890008',
                'birth_place' => 'Yogyakarta',
                'birth_date' => '1995-12-25',
                'gender' => 'Perempuan',
                'nationality' => 'Indonesia',
                'religion' => 'Kristen Katolik',
                'marital_status' => 'Belum Menikah',
                'occupation' => 'Doctor',
                'address_ktp' => 'Jl. Malioboro No. 90, Yogyakarta',
                'address_domisili' => 'Jl. Malioboro No. 90, Yogyakarta',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password'),
                'nik' => '3171234567890009',
                'kk' => '3171234567890010',
                'birth_place' => 'Semarang',
                'birth_date' => '1985-09-30',
                'gender' => 'Laki-laki',
                'nationality' => 'Indonesia',
                'religion' => 'Budha',
                'marital_status' => 'Menikah',
                'occupation' => 'Accountant',
                'address_ktp' => 'Jl. Pemuda No. 56, Semarang',
                'address_domisili' => 'Jl. Pemuda No. 56, Semarang',
            ],
        ];

        foreach ($wargas as $warga) {
            $user = User::create([
                'name' => $warga['name'],
                'email' => $warga['email'],
                'password' => $warga['password'],
            ]);

            $user->assignRole('warga');

            $user->profile()->create([
                'nik' => $warga['nik'],
                'kk' => $warga['kk'],
                'birth_place' => $warga['birth_place'],
                'birth_date' => $warga['birth_date'],
                'gender' => $warga['gender'],
                'nationality' => $warga['nationality'],
                'religion' => $warga['religion'],
                'marital_status' => $warga['marital_status'],
                'occupation' => $warga['occupation'],
                'address_ktp' => $warga['address_ktp'],
                'address_domisili' => $warga['address_domisili'],
            ]);
        }

    }
}
