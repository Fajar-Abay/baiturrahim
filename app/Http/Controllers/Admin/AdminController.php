<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Models\Infaq;
use App\Models\Artikel;
use Spatie\Image\Image;
use App\Models\Pengurus;
use App\Models\Pengeluaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProfileMasjid;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    /**
     * Dashboard utama admin
     */
    public function dashboard()
    {
        // --- Statistik sederhana ---
        $totalInfaq = Infaq::where('status', 'sukses')->sum('nominal');
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $saldo = $totalInfaq - $totalPengeluaran;
        $jumlahArtikel = Artikel::count();

        // --- Status Infaq (pie chart) ---
        $infaqStatus = Infaq::selectRaw('status, COUNT(*) as jumlah')
                            ->groupBy('status')
                            ->pluck('jumlah','status');

        // Pastikan default supaya chart tidak error
        $defaultStatus = ['sukses'=>0, 'pending'=>0, 'gagal'=>0];
        $infaqStatus = collect($defaultStatus)->merge($infaqStatus);

        // --- Infaq & Pengeluaran Bulanan (bar chart) ---
        $infaqBulanan = Infaq::selectRaw('MONTH(created_at) as bulan, SUM(nominal) as total')
                            ->where('status', 'sukses')
                            ->groupBy('bulan')
                            ->pluck('total','bulan')
                            ->map(fn($v)=>(float)$v)
                            ->toArray();

        $pengeluaranBulanan = Pengeluaran::selectRaw('MONTH(created_at) as bulan, SUM(nominal) as total')
                            ->groupBy('bulan')
                            ->pluck('total','bulan')
                            ->map(fn($v)=>(float)$v)
                            ->toArray();

        // Pastikan semua bulan ada
        for($i=1;$i<=12;$i++){
            if(!isset($infaqBulanan[$i])) $infaqBulanan[$i]=0;
            if(!isset($pengeluaranBulanan[$i])) $pengeluaranBulanan[$i]=0;
        }
        ksort($infaqBulanan);
        ksort($pengeluaranBulanan);

        return view('admin.dashboard', compact(
            'totalInfaq',
            'totalPengeluaran',
            'saldo',
            'jumlahArtikel',
            'infaqStatus',
            'infaqBulanan',
            'pengeluaranBulanan'
        ));
    }

    /**
     * Menampilkan profil masjid
     */
    public function profileIndex()
    {
        $profile = ProfileMasjid::first();
        return view('admin.profile.index', compact('profile'));
    }

    /**
     * Update profil masjid - METHOD YANG DIGUNAKAN
     */
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:200',
            'alamat' => 'nullable|string',
            'desa_kecamatan' => 'nullable|string|max:200',
            'foto_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'koordinat_lat' => 'nullable|numeric',
            'koordinat_long' => 'nullable|numeric',
            'id_kota' => 'nullable|integer', // tambahkan untuk jadwal sholat
        ]);

        try {
            $profile = ProfileMasjid::first() ?? new ProfileMasjid();
            $profile->fill($request->except('foto_logo'));

            if ($request->hasFile('foto_logo')) {
                // hapus foto lama jika ada
                if ($profile->foto_logo && Storage::exists($profile->foto_logo)) {
                    Storage::delete($profile->foto_logo);
                }

                // simpan foto baru ke storage/public/logo
                $path = $request->file('foto_logo')->store('logo', 'public');

                // Optimasi gambar
                $this->optimizeImage($path);

                $profile->foto_logo = $path;
            }

            $profile->save();

            return redirect()->back()->with('success', 'Profil masjid berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan jadwal sholat realtime dari API
     */
    public function jadwalSholat()
    {
        $profile = ProfileMasjid::first();
        $id_kota = $profile->id_kota ?? 1217; // default Jakarta
        $tanggal = now()->format('Y-m-d');

        try {
            $response = Http::timeout(10)->get("https://api.myquran.com/v2/sholat/jadwal/{$id_kota}/{$tanggal}");

            if ($response->successful()) {
                $data = $response->json();
                $jadwal = $data['data']['jadwal'] ?? null;
                $kota = $data['data']['lokasi'] ?? null;
            } else {
                $jadwal = null;
                $kota = null;
            }
        } catch (\Throwable $e) {
            \Log::error('Error fetching prayer schedule: ' . $e->getMessage());
            $jadwal = null;
            $kota = null;
        }

        return view('admin.jadwal-sholat.index', compact('jadwal', 'profile', 'kota'));
    }

    /**
     * Menampilkan semua data infaq
     */
    public function infaqIndex(Request $request)
    {
        $query = Infaq::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        }

        $infaq = $query->orderBy('created_at', 'desc')->get();

        return view('admin.infaq.index', compact('infaq'));
    }

    public function infaqCreate()
    {
        return view('admin.infaq.create');
    }

    public function infaqStore(Request $request)
    {

        $request->validate([
            'nama_donatur' => 'required|string|max:150',
            'nominal' => 'required|numeric|min:1000',
            'metode' => 'required|in:online,offline',
            'catatan' => 'nullable|string',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        try {
            $path = null;
            if ($request->hasFile('bukti_transfer')) {

                $fileName = time() . '_' . $request->file('bukti_transfer')->getClientOriginalName();
                $path = $request->file('bukti_transfer')->storeAs('bukti_transfer', $fileName, 'public');

                // Cek jika file benar-benar tersimpan
                if (Storage::disk('public')->exists($path)) {
                    $this->optimizeImage($path);
                } else {
                }
            } else {
            }

            $infaqData = [
                'nama_donatur' => $request->nama_donatur,
                'nominal' => $request->nominal,
                'metode' => $request->metode,
                'status' => 'pending',
                'catatan' => $request->catatan,
                'bukti_transfer' => $path,
            ];

            return redirect()->route('admin.infaq')->with('success', 'Data infaq berhasil ditambahkan dan menunggu konfirmasi.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,sukses,gagal,dibatalkan',
        ]);

        try {
            $infaq = Infaq::findOrFail($id);
            $infaq->update(['status' => $request->status]);

            return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function infaqDestroy($id)
    {
        try {
            $infaq = Infaq::findOrFail($id);

            // Hapus file bukti_transfer dari storage (jika ada)
            if ($infaq->bukti_transfer && Storage::disk('public')->exists($infaq->bukti_transfer)) {
                Storage::disk('public')->delete($infaq->bukti_transfer);
            }

            $infaq->delete();
            return back()->with('success', 'Data infaq berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan semua pengeluaran
     */
    public function pengeluaranIndex(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->search) {
            $query->where('deskripsi', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->tanggal_mulai && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $pengeluarans = $query->latest()->get();

        return view('admin.pengeluaran.index', compact('pengeluarans'));
    }

    public function pengeluaranCreate()
    {
        return view('admin.pengeluaran.create');
    }

    public function pengeluaranStore(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'bukti_pengeluaran' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        try {
            $data = $request->only(['deskripsi', 'kategori', 'nominal', 'tanggal']);

            if ($request->hasFile('bukti_pengeluaran')) {
                $fileName = time().'_'.$request->file('bukti_pengeluaran')->getClientOriginalName();
                $path = $request->file('bukti_pengeluaran')->storeAs('bukti_pengeluaran', $fileName, 'public');
                $this->optimizeImage($path);
                $data['bukti_pengeluaran'] = $path;
            }

            Pengeluaran::create($data);

            return redirect()->route('admin.pengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function pengeluaranDestroy($id)
    {
        try {
            $pengeluaran = Pengeluaran::findOrFail($id);

            if ($pengeluaran->bukti_pengeluaran && Storage::disk('public')->exists($pengeluaran->bukti_pengeluaran)) {
                Storage::disk('public')->delete($pengeluaran->bukti_pengeluaran);
            }

            $pengeluaran->delete();

            return redirect()->route('admin.pengeluaran')->with('success', 'Data pengeluaran berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan semua artikel
     */
    public function artikelIndex(Request $request)
    {
        $query = Artikel::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['draft', 'publish'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sort') && in_array($request->sort, ['baru', 'lama'])) {
            $order = $request->sort == 'baru' ? 'desc' : 'asc';
            $query->orderBy('tanggal_posting', $order);
        } else {
            $query->orderBy('tanggal_posting', 'desc');
        }

        $artikels = $query->paginate(10);

        return view('admin.artikel.index', compact('artikels'));
    }

    public function artikelCreate()
    {
        return view('admin.artikel.create');
    }

    public function artikelStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'penulis' => 'nullable|string|max:100',
            'foto_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'status' => 'required|in:draft,publish',
        ]);

        try {
            $slug = Str::slug($request->judul);
            $data = $request->only(['judul', 'isi', 'penulis', 'status']);
            $data['slug'] = $slug;
            $data['tanggal_posting'] = now();

            if ($request->hasFile('foto_cover')) {
                $fileName = time() . '_' . $request->file('foto_cover')->getClientOriginalName();
                $path = $request->file('foto_cover')->storeAs('artikel', $fileName, 'public');
                $this->optimizeImage($path);
                $data['foto_cover'] = $path;
            }

            Artikel::create($data);

            return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function artikelEdit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function artikelUpdate(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'penulis' => 'nullable|string|max:100',
            'foto_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'status' => 'required|in:draft,publish',
        ]);

        try {
            $data = $request->only(['judul', 'isi', 'penulis', 'status']);
            $data['slug'] = Str::slug($request->judul);

            if ($request->hasFile('foto_cover')) {
                // Hapus foto lama jika ada
                if ($artikel->foto_cover && Storage::disk('public')->exists($artikel->foto_cover)) {
                    Storage::disk('public')->delete($artikel->foto_cover);
                }

                $fileName = time() . '_' . $request->file('foto_cover')->getClientOriginalName();
                $path = $request->file('foto_cover')->storeAs('artikel', $fileName, 'public');
                $this->optimizeImage($path);
                $data['foto_cover'] = $path;
            }

            $artikel->update($data);

            return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function artikelDestroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            if ($artikel->foto_cover && Storage::disk('public')->exists($artikel->foto_cover)) {
                Storage::disk('public')->delete($artikel->foto_cover);
            }

            $artikel->delete();

            return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bagian pengurus
     */
    public function pengurusIndex()
    {
        $penguruses = Pengurus::latest()->get();
        return view('admin.pengurus.index', compact('penguruses'));
    }

    public function pengurusCreate()
    {
        return view('admin.pengurus.create');
    }

    public function pengurusStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:200',
            'jabatan' => 'required|string|max:200',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:200',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('foto')) {
                $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
                $path = $request->file('foto')->storeAs('pengurus', $fileName, 'public');
                $this->optimizeImage($path);
                $data['foto'] = $path;
            }

            Pengurus::create($data);

            return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function pengurusEdit(Pengurus $pengurus)
    {
        return view('admin.pengurus.edit', compact('pengurus'));
    }

    public function pengurusUpdate(Request $request, Pengurus $pengurus)
    {
        $request->validate([
            'nama' => 'required|string|max:200',
            'jabatan' => 'required|string|max:200',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:200',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
                    Storage::disk('public')->delete($pengurus->foto);
                }

                $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
                $path = $request->file('foto')->storeAs('pengurus', $fileName, 'public');
                $this->optimizeImage($path);
                $data['foto'] = $path;
            }

            $pengurus->update($data);

            return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function pengurusDestroy(Pengurus $pengurus)
    {
        try {
            if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
                Storage::disk('public')->delete($pengurus->foto);
            }

            $pengurus->delete();

            return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk optimasi gambar
     */
    private function optimizeImage($path, $quality = 50)
    {
        try {
            $fullPath = storage_path('app/public/' . $path);

            if (file_exists($fullPath)) {
                Image::load($fullPath)
                    ->quality($quality)
                    ->optimize()
                    ->save();
            }
        } catch (\Exception $e) {
            \Log::error('Error optimizing image: ' . $e->getMessage());
        }
    }
}
