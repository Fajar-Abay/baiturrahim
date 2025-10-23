<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\ProfileMasjid;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $profile = ProfileMasjid::first();

        // Ambil semua pengurus dan kelompokkan berdasarkan jabatan
        $penguruses = Pengurus::orderByRaw("
                CASE
                    WHEN jabatan LIKE '%ketua%' THEN 1
                    WHEN jabatan LIKE '%wakil%' THEN 2
                    WHEN jabatan LIKE '%sekretaris%' THEN 3
                    WHEN jabatan LIKE '%bendahara%' THEN 4
                    ELSE 5
                END
            ")
            ->orderBy('nama')
            ->get()
            ->groupBy('jabatan');

        return view('pengurus.index', compact('profile', 'penguruses'));
    }
}
