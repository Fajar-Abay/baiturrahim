<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use App\Models\Galeri;
use App\Models\Artikel;
use App\Models\Pengurus;
use App\Models\Rekening;
use App\Models\Pengeluaran;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use App\Models\ProfileMasjid;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $profile = ProfileMasjid::first();

        // Mengambil 6 artikel terbaru yang publish
        $artikels = Artikel::where('status', 'publish')
            ->latest()
            ->take(6)
            ->get();

        $infaqs = Infaq::where('status', 'sukses')
            ->latest()
            ->take(5)
            ->get();

        $pengeluarans = Pengeluaran::latest()
            ->take(5)
            ->get();

        $penguruses = Pengurus::latest()
            ->take(8)
            ->get();

        $rekening = Rekening::first();
        $galeris = Galeri::latest()->take(6)->get();
        $penghargaans = Penghargaan::latest()->take(6)->get();

        $id_kota = $profile->id_kota ?? 1217; // Default Sumedang
        $tanggal = now()->format('Y-m-d');
        $jadwal = null;

        try {
            $response = Http::timeout(10)->get("https://api.myquran.com/v2/sholat/jadwal/{$id_kota}/{$tanggal}");
            if ($response->successful()) {
                $json = $response->json();
                if (isset($json['data']['jadwal'])) {
                    $jadwal = $json['data']['jadwal'];
                }
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengambil jadwal sholat: ' . $e->getMessage());
        }

        return view('home', compact(
            'profile',
            'artikels',
            'infaqs',
            'penguruses',
            'pengeluarans',
            'jadwal',
            'rekening',
            'galeris',
            'penghargaans'
        ));
    }

    public function profile()
    {
        $profile = ProfileMasjid::first();
        return view('profile', compact('profile'));
    }
}
