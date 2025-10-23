<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rekening;
use Illuminate\Support\Facades\Storage;

class RekeningController extends Controller
{
    public function index()
    {
        $rekenings = Rekening::latest()->get();
        return view('admin.rekening.index', compact('rekenings'));
    }

    public function create()
    {
        return view('admin.rekening.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
            'qris_code' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_bank', 'nomor_rekening', 'atas_nama']);

        if ($request->hasFile('qris_code')) {
            $data['qris_code'] = $request->file('qris_code')->store('qris', 'public');
        }

        Rekening::create($data);
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil ditambahkan!');
    }

    public function edit(Rekening $rekening)
    {
        return view('admin.rekening.edit', compact('rekening'));
    }

    public function update(Request $request, Rekening $rekening)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
            'qris_code' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_bank', 'nomor_rekening', 'atas_nama']);

        if ($request->hasFile('qris_code')) {
            if ($rekening->qris_code && Storage::disk('public')->exists($rekening->qris_code)) {
                Storage::disk('public')->delete($rekening->qris_code);
            }
            $data['qris_code'] = $request->file('qris_code')->store('qris', 'public');
        }

        $rekening->update($data);
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil diperbarui!');
    }

    public function destroy(Rekening $rekening)
    {
        if ($rekening->qris_code && Storage::disk('public')->exists($rekening->qris_code)) {
            Storage::disk('public')->delete($rekening->qris_code);
        }

        $rekening->delete();
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil dihapus!');
    }
}
