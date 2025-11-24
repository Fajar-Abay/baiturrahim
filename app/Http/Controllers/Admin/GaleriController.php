<?php

namespace App\Http\Controllers\Admin;

use App\Models\Galeri;
use Spatie\Image\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Image\Drivers\ImageDriver;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->get();
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'deskripsi' => 'nullable',
        ]);

        $filename = time().'.'.$request->foto->extension();
        $path = $request->foto->storeAs('galeri', $filename, 'public');

        Image::load(storage_path('app/public/' . $path))
            ->optimize()
            ->quality(50)
            ->save(public_path('storage/galeri/' . $filename));

        Galeri::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $path,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'deskripsi' => 'nullable',
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('foto')) {
            if ($galeri->foto && file_exists(public_path('storage/' . $galeri->foto))) {
                unlink(public_path('storage/' . $galeri->foto));
            }

            $filename = time() . '.' . $request->foto->extension();
            $path = $request->foto->storeAs('galeri', $filename, 'public');

            $folder = public_path('storage/galeri');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            Image::load(storage_path('app/public/' . $path))
                ->quality(50)
                ->optimize()
                ->save($folder . '/' . $filename);

            Storage::disk('public')->delete($path);
            
            $data['foto'] = 'galeri/' . $filename;
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil diperbarui.');
    }


    public function destroy(Galeri $galeri)
    {
        if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus.');
    }
}
