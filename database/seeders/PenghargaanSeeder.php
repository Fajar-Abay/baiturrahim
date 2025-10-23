<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenghargaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('penghargaans')->insert([
            [
                'name' => 'Masjid Terbersih Tingkat Kecamatan',
                'foto' => 'images/penghargaan/masjid-terbersih.jpg',
                'deskripsi' => 'Masjid Al-Ikhlas meraih penghargaan sebagai masjid terbersih tingkat kecamatan pada tahun 2023.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Partisipasi Aktif dalam Kegiatan Sosial',
                'foto' => 'images/penghargaan/partisipasi-sosial.jpg',
                'deskripsi' => 'Diberikan oleh Pemerintah Kabupaten Sumedang atas peran aktif dalam kegiatan sosial dan kemanusiaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juara 1 Lomba Kebersihan Masjid',
                'foto' => 'images/penghargaan/lomba-kebersihan.jpg',
                'deskripsi' => 'Berhasil meraih juara pertama dalam lomba kebersihan masjid tingkat kabupaten.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apresiasi Kegiatan Remaja Masjid Terbaik',
                'foto' => 'images/penghargaan/remaja-masjid.jpg',
                'deskripsi' => 'Diberikan kepada remaja masjid yang aktif menyelenggarakan kegiatan positif bagi masyarakat sekitar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Piagam Donor Darah Massal',
                'foto' => 'images/penghargaan/donor-darah.jpg',
                'deskripsi' => 'Penghargaan dari Palang Merah Indonesia atas partisipasi dalam acara donor darah massal di lingkungan masjid.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
