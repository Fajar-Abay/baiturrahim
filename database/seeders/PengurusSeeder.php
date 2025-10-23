<?php

namespace Database\Seeders;

use App\Models\Pengurus;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    public function run()
    {
        $penguruses = [
            [
                'nama' => 'Dr. Ahmad Hidayat, Lc., M.A.',
                'jabatan' => 'Ketua DKM',
                'foto' => 'pengurus/ketua.jpg',
                'no_hp' => '081234567890',
                'email' => 'ahmad.hidayat@masjid.com',
                'alamat' => 'Jl. Merdeka No. 123'
            ],
            [
                'nama' => 'Muhammad Rizki, S.Ag.',
                'jabatan' => 'Wakil Ketua DKM',
                'foto' => 'pengurus/wakil.jpg',
                'no_hp' => '081234567891',
                'email' => 'rizki@masjid.com',
                'alamat' => 'Jl. Sudirman No. 45'
            ],
            [
                'nama' => 'Siti Aminah, S.Pd.',
                'jabatan' => 'Sekretaris',
                'foto' => 'pengurus/sekretaris.jpg',
                'no_hp' => '081234567892',
                'email' => 'aminah@masjid.com',
                'alamat' => 'Jl. Diponegoro No. 67'
            ],
            [
                'nama' => 'Budi Santoso, S.E.',
                'jabatan' => 'Bendahara',
                'foto' => 'pengurus/bendahara.jpg',
                'no_hp' => '081234567893',
                'email' => 'budi@masjid.com',
                'alamat' => 'Jl. Gatot Subroto No. 89'
            ],
            [
                'nama' => 'Abdul Rahman',
                'jabatan' => 'Anggota',
                'foto' => 'pengurus/anggota1.jpg',
                'no_hp' => '081234567894',
                'email' => 'abdul@masjid.com',
                'alamat' => 'Jl. Pahlawan No. 12'
            ],
            [
                'nama' => 'Fatimah Azzahra',
                'jabatan' => 'Anggota',
                'foto' => 'pengurus/anggota2.jpg',
                'no_hp' => '081234567895',
                'email' => 'fatimah@masjid.com',
                'alamat' => 'Jl. Melati No. 34'
            ],
            [
                'nama' => 'Ibrahim Khalil',
                'jabatan' => 'Anggota',
                'foto' => 'pengurus/anggota3.jpg',
                'no_hp' => '081234567896',
                'email' => 'ibrahim@masjid.com',
                'alamat' => 'Jl. Kenanga No. 56'
            ],
            [
                'nama' => 'Mariam Ummu',
                'jabatan' => 'Anggota',
                'foto' => 'pengurus/anggota4.jpg',
                'no_hp' => '081234567897',
                'email' => 'mariam@masjid.com',
                'alamat' => 'Jl. Flamboyan No. 78'
            ]
        ];

        foreach ($penguruses as $pengurus) {
            Pengurus::create($pengurus);
        }
    }
}
