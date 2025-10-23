<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use App\Models\Pengeluaran;
use App\Models\ProfileMasjid;
use Illuminate\Http\Request;

class TransparansiController extends Controller
{
    public function index()
    {
        $profile = ProfileMasjid::first();

        // Data infaq yang sukses
        $infaqs = Infaq::where('status', 'sukses')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'infaq_page');

        // Data pengeluaran
        $pengeluarans = Pengeluaran::orderBy('tanggal', 'desc')
            ->paginate(10, ['*'], 'pengeluaran_page');

        // Statistik keuangan
        $total_infaq = Infaq::where('status', 'sukses')->sum('nominal');
        $total_pengeluaran = Pengeluaran::sum('nominal');
        $saldo = $total_infaq - $total_pengeluaran;

        // Infaq terbaru (untuk widget)
        $infaq_terbaru = Infaq::where('status', 'sukses')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Pengeluaran terbesar
        $pengeluaran_terbesar = Pengeluaran::orderBy('nominal', 'desc')
            ->take(5)
            ->get();

        return view('transparansi.index', compact(
            'profile',
            'infaqs',
            'pengeluarans',
            'total_infaq',
            'total_pengeluaran',
            'saldo',
            'infaq_terbaru',
            'pengeluaran_terbesar'
        ));
    }
}
