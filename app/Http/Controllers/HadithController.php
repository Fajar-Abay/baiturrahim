<?php

namespace App\Http\Controllers;

use App\Services\HadithService;
use Illuminate\Http\Request;

class HadithController extends Controller
{
    protected $hadithService;

    public function __construct(HadithService $hadithService)
    {
        $this->hadithService = $hadithService;
    }

    /**
     * Display list of hadith books for public
     */
    public function index()
    {
        $books = $this->hadithService->getBooks();

        $pageTitle = "Kitab Hadits";
        $pageDescription = "Kumpulan kitab-kitab hadits shahih dengan terjemahan Bahasa Indonesia";

        return view('hadith.index', compact('books', 'pageTitle', 'pageDescription'));
    }

    /**
     * Show hadiths from a specific book for public
     */
    public function showHadiths(Request $request, $book)
    {
        // Validasi input
        $validated = $request->validate([
            'range' => 'nullable|string|regex:/^\d+-\d+$/',
            'perpage' => 'nullable|integer|min:1|max:300'
        ]);

        $range = $validated['range'] ?? null;
        $perPage = $validated['perpage'] ?? 50;

        $result = $this->hadithService->getHadiths($book, $range, $perPage);

        // Handle error response
        if (!$result || (isset($result['code']) && $result['code'] !== 200)) {
            $errorMessage = $result['message'] ?? 'Gagal memuat data hadits. Silakan coba beberapa saat lagi.';
            return redirect()->route('hadith.index')
                ->with('error', $errorMessage);
        }

        // Validasi struktur data
        if (!isset($result['data']) || !is_array($result['data'])) {
            return redirect()->route('hadith.index')
                ->with('error', 'Format data hadits tidak valid.');
        }

        $bookInfo = [
            'id' => $book,
            'name' => $result['data']['name'] ?? $this->getBookName($book),
            'available' => $result['data']['available'] ?? 0,
            'requested_range' => $result['data']['requested_range'] ?? null
        ];

        $pageTitle = "Hadits " . $bookInfo['name'];
        $pageDescription = "Baca kumpulan hadits dari " . $bookInfo['name'];

        return view('hadith.show', compact('result', 'bookInfo', 'pageTitle', 'pageDescription'));
    }

    /**
     * Search hadiths for public
     */
    public function search(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'q' => 'nullable|string|min:2|max:100',
            'book' => 'nullable|string',
            'limit' => 'nullable|integer|min:10|max:200'
        ]);

        $query = $validated['q'] ?? null;
        $book = $validated['book'] ?? null;
        $limit = $validated['limit'] ?? 50;

        $pageTitle = "Pencarian Hadits";
        $pageDescription = "Cari hadits berdasarkan kata kunci";

        // Jika tidak ada query, tampilkan form pencarian
        if (!$query) {
            $books = $this->hadithService->getBooks();

            // Handle error jika gagal mengambil data books
            if (isset($books['code']) && $books['code'] !== 200) {
                $books = ['data' => []];
            }

            $popularSearches = $this->getPopularSearches();
            return view('hadith.search', compact('pageTitle', 'pageDescription', 'books', 'popularSearches'));
        }

        // Gunakan search manual
        $results = $this->hadithService->searchHadithsManual($query, $book, $limit);
        $books = $this->hadithService->getBooks();
        $popularSearches = $this->getPopularSearches();

        // Handle error response
        if (!$results || (isset($results['code']) && $results['code'] !== 200)) {
            $errorMessage = $results['message'] ?? 'Gagal melakukan pencarian. Silakan coba beberapa saat lagi.';
            return view('hadith.search', compact('pageTitle', 'pageDescription', 'books', 'popularSearches', 'query'))
                ->with('error', $errorMessage);
        }

        $pageTitle = "Hasil pencarian: \"$query\"";
        $pageDescription = "Ditemukan " . ($results['data']['total'] ?? 0) . " hasil untuk \"$query\"";

        return view('hadith.search', compact('results', 'query', 'book', 'books', 'popularSearches', 'pageTitle', 'pageDescription'));
    }

    /**
     * Show single hadith detail for public
     */
    public function show($book, $number)
    {
        // Validasi input
        if (!is_numeric($number) || $number < 1) {
            return redirect()->route('hadith.show', $book)
                ->with('error', 'Nomor hadits tidak valid.');
        }

        $result = $this->hadithService->getHadith($book, $number);

        // Handle error response
        if (!$result || (isset($result['code']) && $result['code'] !== 200)) {
            $errorMessage = $result['message'] ?? 'Hadits tidak ditemukan.';
            return redirect()->route('hadith.show', $book)
                ->with('error', $errorMessage);
        }

        // Struktur data: result['data']['contents']
        if (!isset($result['data']['contents'])) {
            return redirect()->route('hadith.show', $book)
                ->with('error', 'Format data hadits tidak valid.');
        }

        $bookData = $result['data'];
        $hadithContents = $bookData['contents'];

        // Buat bookInfo
        $bookInfo = [
            'id' => $book,
            'name' => $bookData['name'] ?? $this->getBookName($book),
            'available' => $bookData['available'] ?? 0
        ];

        // Gabungkan data hadits
        $hadithData = [
            'number' => $hadithContents['number'] ?? $number,
            'arab' => $hadithContents['arab'] ?? 'Teks arab tidak tersedia',
            'id' => $hadithContents['id'] ?? 'Terjemahan tidak tersedia'
        ];

        $pageTitle = "Hadits " . $bookInfo['name'] . " No. " . $hadithData['number'];
        $pageDescription = "Baca hadits " . $bookInfo['name'] . " nomor " . $hadithData['number'];

        return view('hadith.detail', compact('hadithData', 'bookInfo', 'pageTitle', 'pageDescription'));
    }
    /**
     * Get book name from ID
     */
    private function getBookName($bookId)
    {
        $bookNames = [
            'bukhari' => 'Shahih Bukhari',
            'muslim' => 'Shahih Muslim',
            'abu-daud' => 'Sunan Abu Daud',
            'tirmidzi' => 'Sunan Tirmidzi',
            'nasai' => 'Sunan Nasai',
            'ibnu-majah' => 'Sunan Ibnu Majah',
            'ahmad' => 'Musnad Ahmad',
            'darimi' => 'Sunan Darimi',
            'malik' => 'Muwatha Malik'
        ];

        return $bookNames[$bookId] ?? ucfirst($bookId);
    }

    /**
     * Get popular search terms
     */
    private function getPopularSearches()
    {
        return [
            'shalat', 'zakat', 'puasa', 'nikah', 'jual beli',
            'iman', 'islam', 'sabar', 'syukur', 'dosa',
            'Rasulullah', 'wudhu', 'haji', 'riba', 'orang tua'
        ];
    }

    /**
     * Helper untuk highlight text
     */
    private function highlightText($text, $query)
    {
        if (empty($text) || empty($query)) {
            return $text;
        }

        $pattern = '/(' . preg_quote($query, '/') . ')/i';
        return preg_replace($pattern, '<span class="highlight">$1</span>', $text);
    }
}
