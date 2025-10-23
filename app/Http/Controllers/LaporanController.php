<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Infaq;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal
        $start = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $end = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        // Data infaq sukses
        $infaq = Infaq::where('status', 'sukses')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Data pengeluaran - debugging
        Log::info('Pengeluaran Query:', [
            'start' => $start->toDateString(),
            'end' => $end->toDateString()
        ]);

        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$start, $end])->get();
        // Hitung total
        $total_infaq = $infaq->sum('nominal');
        $total_pengeluaran = $pengeluaran->sum('nominal');
        $saldo = $total_infaq - $total_pengeluaran;

        return view('admin.laporan.index', compact(
            'infaq', 'pengeluaran', 'total_infaq', 'total_pengeluaran', 'saldo', 'start', 'end'
        ));
    }

    public function export(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $end = $request->end_date ? Carbon::parse($request->end_date) : now()->endOfMonth();

        // Set session untuk feedback
        session()->flash('download_started', true);

        $timestamp = now()->format('Y-m-d-His');
        $filename = "laporan-masjid-{$start->format('Y-m-d')}-to-{$end->format('Y-m-d')}-{$timestamp}.xlsx";

        return Excel::download(new LaporanExport($start, $end), $filename);
    }
}
