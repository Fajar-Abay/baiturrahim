<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    QuranController,
    ArtikelController,
    PengurusController,
    TransparansiController
};
use App\Http\Controllers\Admin\{
    AdminController,
    GaleriController,
    RekeningController,
    PenghargaanController
};

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
// ===============================
// 🌙 HALAMAN PUBLIK
// ===============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profile'])->name('profil');

Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus.index');
Route::get('/infaq', [TransparansiController::class, 'index'])->name('transparansi.index');

Route::prefix('alquran')->name('alquran.')->group(function () {
    Route::get('/', [QuranController::class, 'index'])->name('index');
    Route::get('/{nomor}', [QuranController::class, 'show'])->name('show');
});

Route::prefix('artikel')->name('artikel.')->group(function () {
    Route::get('/', [ArtikelController::class, 'index'])->name('index');
    Route::get('/{slug}', [ArtikelController::class, 'show'])->name('show');
});

// ===============================
// 🛡️ HALAMAN ADMIN (Hanya untuk Admin)
// ===============================
Route::prefix('admin')
        ->name('admin.')
        ->middleware(['admin']) // pastikan kamu sudah buat middleware 'admin'
        ->group(function () {

        // Dashboard & Profil
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [AdminController::class, 'profileIndex'])->name('profil');
        Route::post('/profil/update', [AdminController::class, 'profileUpdate'])->name('profile.update');

        // 💰 Infaq
        Route::get('/infaq', [AdminController::class, 'infaqIndex'])->name('infaq');
        Route::get('/infaq/create', [AdminController::class, 'infaqCreate'])->name('infaq.create');
        Route::post('/infaq/store', [AdminController::class, 'infaqStore'])->name('infaq.store');
        Route::put('/infaq/{id}/status', [AdminController::class, 'updateStatus'])->name('infaq.updateStatus');
        Route::delete('/infaq/{id}', [AdminController::class, 'infaqDestroy'])->name('infaq.destroy');

        // 📉 Pengeluaran
        Route::get('/pengeluaran', [AdminController::class, 'pengeluaranIndex'])->name('pengeluaran');
        Route::get('/pengeluaran/create', [AdminController::class, 'pengeluaranCreate'])->name('pengeluaran.create');
        Route::post('/pengeluaran/store', [AdminController::class, 'pengeluaranStore'])->name('pengeluaran.store');
        Route::delete('/pengeluaran/{id}', [AdminController::class, 'pengeluaranDestroy'])->name('pengeluaran.destroy');

        // 📰 Artikel
        Route::get('/artikel', [AdminController::class, 'artikelIndex'])->name('artikel');
        Route::get('/artikel/create', [AdminController::class, 'artikelCreate'])->name('artikel.create');
        Route::post('/artikel/store', [AdminController::class, 'artikelStore'])->name('artikel.store');
        Route::get('/artikel/{id}/edit', [AdminController::class, 'artikelEdit'])->name('artikel.edit');
        Route::put('/artikel/{id}/update', [AdminController::class, 'artikelUpdate'])->name('artikel.update');
        Route::delete('/artikel/{id}', [AdminController::class, 'artikelDestroy'])->name('artikel.destroy');

        // 🧍 Pengurus
        Route::get('/pengurus', [AdminController::class, 'pengurusIndex'])->name('pengurus.index');
        Route::get('/pengurus/create', [AdminController::class, 'pengurusCreate'])->name('pengurus.create');
        Route::post('/pengurus', [AdminController::class, 'pengurusStore'])->name('pengurus.store');
        Route::get('/pengurus/{pengurus}/edit', [AdminController::class, 'pengurusEdit'])->name('pengurus.edit');
        Route::put('/pengurus/{pengurus}', [AdminController::class, 'pengurusUpdate'])->name('pengurus.update');
        Route::delete('/pengurus/{pengurus}', [AdminController::class, 'pengurusDestroy'])->name('pengurus.destroy');

        // 🖼️ Resource Controller
        Route::resources([
            'rekening' => RekeningController::class,
            'galeri' => GaleriController::class,
            'penghargaan' => PenghargaanController::class,
        ]);

        Route::get("/logout", [AuthController::class,"logout"])->name("logout");

        // 🕌 Jadwal Sholat
        Route::get('/jadwal-sholat', [AdminController::class, 'jadwalSholat'])->name('jadwal-sholat');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    });

    Route::get("/login", [AuthController::class,"showLoginForm"])->name("login");
    Route::post("/login", [AuthController::class,"login"])->name("login.post");

