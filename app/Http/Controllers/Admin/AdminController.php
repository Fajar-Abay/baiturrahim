<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Models\Infaq;
use App\Models\Artikel;
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
        $profile = ProfileMasjid::first(); // hanya 1 data saja
        return view('admin.profile.index', compact('profile'));
    }

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
        ]);

        $profile = ProfileMasjid::first() ?? new ProfileMasjid();
        $profile->fill($request->except('foto_logo'));

        if ($request->hasFile('foto_logo')) {
            // hapus foto lama jika ada
            if ($profile->foto_logo && Storage::exists($profile->foto_logo)) {
                Storage::delete($profile->foto_logo);
            }

            // simpan foto baru ke storage/public/logo
            $path = $request->file('foto_logo')->store('logo', 'public');
            $profile->foto_logo = $path;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil masjid berhasil diperbarui!');
    }

    /**
     * Update profil masjid
     */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:200',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $profil = ProfileMasjid::firstOrCreate(['id' => 1]);
        $profil->update($request->all());

        return redirect()->back()->with('success', 'Profil masjid berhasil diperbarui.');
    }

    /**
     * Menampilkan jadwal sholat realtime dari API
     */
    public function jadwalSholat()
    {
        // Ambil data masjid (lokasi)
        $profile = ProfileMasjid::first();

        $id_kota = $profile->id_kota ?? 1217;

        // Format tanggal hari ini
        $tanggal = now()->format('Y-m-d');

        try {
            // Panggil API MyQuran
            $response = Http::timeout(10)->get("https://api.myquran.com/v2/sholat/jadwal/{$id_kota}/{$tanggal}");

            if ($response->successful()) {
                $data = $response->json();

                // Pastikan struktur data sesuai
                $jadwal = $data['data']['jadwal'] ?? null;
            } else {
                $jadwal = null;
            }
        } catch (\Throwable $e) {
            // Tangani error jaringan atau JSON parsing
            $jadwal = null;
        }

        return view('admin.jadwal-sholat.index', compact('jadwal', 'profile'));
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
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // Simpan bukti transfer
        $fileName = time() . '_' . $request->file('bukti_transfer')->getClientOriginalName();
        $path = $request->file('bukti_transfer')->storeAs('bukti_transfer', $fileName, 'public');

        Infaq::create([
            'nama_donatur' => $request->nama_donatur,
            'nominal' => $request->nominal,
            'metode' => $request->metode,
            'status' => 'pending', // default
            'catatan' => $request->catatan,
            'bukti_transfer' => $path,
        ]);

        return redirect()->route('admin.infaq')->with('success', 'Data infaq berhasil ditambahkan dan menunggu konfirmasi.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,sukses,gagal,dibatalkan',
        ]);

        $infaq = Infaq::findOrFail($id);
        $infaq->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }


    public function infaqDestroy($id)
    {
        $infaq = Infaq::findOrFail($id);

        // Hapus file bukti_transfer dari storage (jika ada)
        if ($infaq->bukti_transfer && Storage::disk('public')->exists($infaq->bukti_transfer)) {
            Storage::disk('public')->delete($infaq->bukti_transfer);
        }

        $infaq->delete();
        return back()->with('success', 'Data infaq berhasil dihapus.');
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
            'bukti_pengeluaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['deskripsi', 'kategori', 'nominal', 'tanggal']);

        if ($request->hasFile('bukti_pengeluaran')) {
            $file = $request->file('bukti_pengeluaran');
            $path = $file->store('bukti_pengeluaran', 'public');
            $data['bukti_pengeluaran'] = $path;
        }

        Pengeluaran::create($data);

        return redirect()->route('admin.pengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    public function pengeluaranDestroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        if ($pengeluaran->bukti_pengeluaran && file_exists(storage_path('app/public/' . $pengeluaran->bukti_pengeluaran))) {
            unlink(storage_path('app/public/' . $pengeluaran->bukti_pengeluaran));
        }

        $pengeluaran->delete();

        return redirect()->route('admin.pengeluaran')->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    /**
     * Menampilkan semua artikel
     */
   // --- ARTIKEL ---
    public function artikelIndex(Request $request)
    {
        $query = Artikel::query();

        // 🔍 Pencarian berdasarkan judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // 🏷️ Filter status
        if ($request->filled('status') && in_array($request->status, ['draft', 'publish'])) {
            $query->where('status', $request->status);
        }

        // 📅 Sortir tanggal
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
            'foto_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $slug = Str::slug($request->judul);
        $data = $request->only(['judul', 'isi', 'penulis', 'status']);
        $data['slug'] = $slug;
        $data['tanggal_posting'] = now();

        if ($request->hasFile('foto_cover')) {
            $file = $request->file('foto_cover');
            $path = $file->store('artikel', 'public');
            $data['foto_cover'] = $path;
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil ditambahkan.');
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
            'foto_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $data = $request->only(['judul', 'isi', 'penulis', 'status']);
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('foto_cover')) {
            if ($artikel->foto_cover && file_exists(storage_path('app/public/' . $artikel->foto_cover))) {
                unlink(storage_path('app/public/' . $artikel->foto_cover));
            }

            $path = $request->file('foto_cover')->store('artikel', 'public');
            $data['foto_cover'] = $path;
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function artikelDestroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->foto_cover && file_exists(storage_path('app/public/' . $artikel->foto_cover))) {
            unlink(storage_path('app/public/' . $artikel->foto_cover));
        }

        $artikel->delete();

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil dihapus.');
    }

    // bagian pengurus

        public function PengurusIndex()
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

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        Pengurus::create($data);

        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan!');
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

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($pengurus->foto) {
                Storage::disk('public')->delete($pengurus->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $pengurus->update($data);

        return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function pengurusDestroy(Pengurus $pengurus)
    {
        if ($pengurus->foto) {
            Storage::disk('public')->delete($pengurus->foto);
        }
        $pengurus->delete();
        return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil dihapus!');
    }
}
