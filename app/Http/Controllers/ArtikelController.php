<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::where('status', 'publish')
            ->orderBy('tanggal_posting', 'desc')
            ->paginate(6); // Kurangi menjadi 6 untuk featured + grid

        $artikel_terbaru = Artikel::where('status', 'publish')
            ->orderBy('tanggal_posting', 'desc')
            ->take(5)
            ->get();

        return view('artikel.index', compact('artikels', 'artikel_terbaru'));
    }

    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        $artikel_terkait = Artikel::where('status', 'publish')
            ->where('id', '!=', $artikel->id)
            ->where(function($query) use ($artikel) {
                $query->where('penulis', $artikel->penulis)
                      ->orWhere('judul', 'like', '%' . substr($artikel->judul, 0, 20) . '%');
            })
            ->orderBy('tanggal_posting', 'desc')
            ->take(3)
            ->get();

        $artikel_terbaru = Artikel::where('status', 'publish')
            ->where('id', '!=', $artikel->id)
            ->orderBy('tanggal_posting', 'desc')
            ->take(5)
            ->get();




        return view('artikel.show', compact('artikel', 'artikel_terkait', 'artikel_terbaru'));
    }
}
