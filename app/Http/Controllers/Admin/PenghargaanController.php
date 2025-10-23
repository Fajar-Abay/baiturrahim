<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penghargaan;
use Illuminate\Support\Facades\Storage;

class PenghargaanController extends Controller
{
    public function index()
    {
        $penghargaans = Penghargaan::latest()->get();
        return view('admin.penghargaan.index', compact('penghargaans'));
    }

    public function create()
    {
        return view('admin.penghargaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable',
        ]);

        $data = $request->only(['name', 'deskripsi']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('penghargaan', 'public');
        }

        Penghargaan::create($data);

        return redirect()->route('admin.penghargaan.index')->with('success', 'Penghargaan berhasil ditambahkan.');
    }

    public function edit(Penghargaan $penghargaan)
    {
        return view('admin.penghargaan.edit', compact('penghargaan'));
    }

    public function update(Request $request, Penghargaan $penghargaan)
    {
        $request->validate([
            'name' => 'required|max:150',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable',
        ]);

        $data = $request->only(['name', 'deskripsi']);

        if ($request->hasFile('foto')) {
            if ($penghargaan->foto && Storage::disk('public')->exists($penghargaan->foto)) {
                Storage::disk('public')->delete($penghargaan->foto);
            }
            $data['foto'] = $request->file('foto')->store('penghargaan', 'public');
        }

        $penghargaan->update($data);

        return redirect()->route('admin.penghargaan.index')->with('success', 'Penghargaan berhasil diperbarui.');
    }

    public function destroy(Penghargaan $penghargaan)
    {
        if ($penghargaan->foto && Storage::disk('public')->exists($penghargaan->foto)) {
            Storage::disk('public')->delete($penghargaan->foto);
        }

        $penghargaan->delete();
        return redirect()->route('admin.penghargaan.index')->with('success', 'Penghargaan berhasil dihapus.');
    }
}
