<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('galeris')->insert([
            [
                'judul' => 'Ruang Utama Masjid',
                'deskripsi' => 'Ruang utama digunakan untuk kegiatan ibadah harian dan salat Jumat. Dilengkapi dengan karpet tebal dan sistem pendingin udara.',
                'foto' => 'images/galeri/ruang-utama.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Tempat Wudhu Pria dan Wanita',
                'deskripsi' => 'Terdapat tempat wudhu terpisah untuk pria dan wanita dengan fasilitas air mengalir dan kebersihan yang terjaga.',
                'foto' => 'images/galeri/tempat-wudhu.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Halaman Masjid',
                'deskripsi' => 'Halaman luas digunakan untuk kegiatan sosial seperti pengajian, bazar, dan acara keagamaan lainnya.',
                'foto' => 'images/galeri/halaman.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Perpustakaan Islam',
                'deskripsi' => 'Menyediakan berbagai koleksi buku keagamaan, tafsir, dan buku pengetahuan umum bagi jamaah.',
                'foto' => 'images/galeri/perpustakaan.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kegiatan Buka Puasa Bersama',
                'deskripsi' => 'Setiap bulan Ramadhan, masjid menyelenggarakan kegiatan buka puasa bersama masyarakat sekitar.',
                'foto' => 'images/galeri/buka-puasa.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kegiatan Pengajian Mingguan',
                'deskripsi' => 'Pengajian rutin setiap malam Jumat dengan berbagai tema keislaman dan tausiyah dari ustadz lokal.',
                'foto' => 'images/galeri/pengajian.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
