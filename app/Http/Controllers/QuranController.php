<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class QuranController extends Controller
{
    // Menampilkan daftar surat
    public function index(Request $request)
    {
        $response = Http::get('https://equran.id/api/v2/surat');

        $surat = [];
        if ($response->successful()) {
            $surat = $response->json()['data'];

            // Fitur pencarian
            if ($request->has('search') && !empty($request->search)) {
                $search = strtolower($request->search);
                $surat = array_filter($surat, function($item) use ($search) {
                    return strpos(strtolower($item['namaLatin']), $search) !== false ||
                           strpos(strtolower($item['arti']), $search) !== false;
                });
            }
        }

        return view('alquran.index', compact('surat'));
    }

    public function show($nomor)
    {
        // Ambil data surat
        $response = Http::get("https://equran.id/api/v2/surat/{$nomor}");

        if (!$response->successful()) {
            abort(404, 'Surat tidak ditemukan.');
        }

        $data = $response->json()['data'];
        $tafsirResponse = Http::get("https://equran.id/api/v2/tafsir/{$nomor}");

        $tafsir = [];
        if ($tafsirResponse->successful()) {
            $tafsirData = $tafsirResponse->json()['data'];
            foreach ($tafsirData['tafsir'] as $t) {
                $tafsir[$t['ayat']] = $t;
            }
        }

        return view('alquran.show', compact('data', 'tafsir'));
    }
}
