<?php

namespace App\Exports;

use App\Models\Infaq;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\Log;

class LaporanExport implements WithMultipleSheets
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = Carbon::parse($start)->startOfDay();
        $this->end = Carbon::parse($end)->endOfDay();
    }

    public function sheets(): array
    {
        return [
            new InfaqSheet($this->start, $this->end),
            new PengeluaranSheet($this->start, $this->end),
            new RingkasanSheet($this->start, $this->end),
        ];
    }
}

/* ===========================
   🕌 SHEET 1 — DATA INFAQ
   =========================== */
class InfaqSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $infaq = Infaq::where('status', 'sukses')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->orderBy('created_at', 'asc')
            ->get(['nama_donatur', 'nominal', 'metode', 'status', 'created_at']);

        if ($infaq->isEmpty()) {
            return collect([['Tidak ada data infaq untuk periode ini']]);
        }

        return $infaq->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Nama Donatur' => $item->nama_donatur,
                'Nominal' => $item->nominal,
                'Metode' => ucfirst($item->metode),
                'Status' => ucfirst($item->status),
                'Tanggal' => Carbon::parse($item->created_at)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Donatur', 'Nominal (Rp)', 'Metode', 'Status', 'Tanggal'];
    }

    public function title(): string
    {
        return 'Data Infaq';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2d6a4f']],
            'alignment' => ['horizontal' => 'center']
        ]);
        $sheet->getStyle('A1:F' . $highestRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
        ]);
        return [];
    }

    public function columnWidths(): array
    {
        return ['A' => 8, 'B' => 25, 'C' => 20, 'D' => 15, 'E' => 12, 'F' => 12];
    }
}

/* ===========================
   💸 SHEET 2 — PENGELUARAN
   =========================== */
class PengeluaranSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$this->start->toDateString(), $this->end->toDateString()])
            ->orderBy('tanggal', 'asc')
            ->get(['deskripsi', 'kategori', 'nominal', 'tanggal']);

        if ($pengeluaran->isEmpty()) {
            return collect([['Tidak ada data pengeluaran untuk periode ini']]);
        }

        return $pengeluaran->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Deskripsi' => $item->deskripsi,
                'Kategori' => $item->kategori ?? '-',
                'Nominal' => $item->nominal,
                'Tanggal' => Carbon::parse($item->tanggal)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Deskripsi', 'Kategori', 'Nominal (Rp)', 'Tanggal'];
    }

    public function title(): string
    {
        return 'Data Pengeluaran';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'd00000']],
            'alignment' => ['horizontal' => 'center']
        ]);
        $sheet->getStyle('A1:E' . $highestRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
        ]);
        return [];
    }

    public function columnWidths(): array
    {
        return ['A' => 8, 'B' => 35, 'C' => 20, 'D' => 20, 'E' => 12];
    }
}

/* ===========================
   📊 SHEET 3 — RINGKASAN
   =========================== */
class RingkasanSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $total_infaq = Infaq::where('status', 'sukses')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->sum('nominal');

        $total_pengeluaran = Pengeluaran::whereBetween('tanggal', [$this->start->toDateString(), $this->end->toDateString()])
            ->sum('nominal');

        $saldo = $total_infaq - $total_pengeluaran;

        return collect([
            ['Keterangan' => 'Total Infaq', 'Nominal' => $total_infaq],
            ['Keterangan' => 'Total Pengeluaran', 'Nominal' => $total_pengeluaran],
            ['Keterangan' => 'Saldo Akhir', 'Nominal' => $saldo],
        ]);
    }

    public function headings(): array
    {
        return ['Keterangan', 'Nominal (Rp)'];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1a6b4b']],
            'alignment' => ['horizontal' => 'center']
        ]);
        $sheet->getStyle('A1:B4')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
        ]);
        $sheet->getStyle('B2:B4')->getNumberFormat()->setFormatCode('#,##0');
        return [];
    }

    public function columnWidths(): array
    {
        return ['A' => 25, 'B' => 25];
    }
}
