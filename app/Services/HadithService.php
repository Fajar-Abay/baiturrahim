<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class HadithService
{
    private $baseUrl = "https://api.hadith.gading.dev";

    /**
     * Get all available books
     */
    public function getBooks()
    {
        try {
            return Cache::remember('hadith_books', 3600, function () {
                $response = Http::timeout(30)->get("{$this->baseUrl}/books");

                if ($response->successful()) {
                    return $response->json();
                }

                throw new Exception('Failed to fetch books from API');
            });
        } catch (Exception $e) {
            return [
                'code' => 500,
                'message' => 'Gagal memuat daftar kitab hadits',
                'data' => null
            ];
        }
    }

    /**
     * Get hadiths from a specific book
     */
    public function getHadiths($book, $range = null, $perPage = null)
    {
        try {
            $cacheKey = "hadith_{$book}" . ($range ? "_$range" : "") . ($perPage ? "_$perPage" : "");

            return Cache::remember($cacheKey, 3600, function () use ($book, $range, $perPage) {
                $url = "{$this->baseUrl}/books/{$book}";

                $params = [];
                if ($range) {
                    $params['range'] = $range;
                } elseif ($perPage) {
                    $params['range'] = "1-{$perPage}";
                }

                $response = Http::timeout(30)->get($url, $params);

                if ($response->successful()) {
                    return $response->json();
                }

                throw new Exception('API returned status: ' . $response->status());
            });
        } catch (Exception $e) {
            return [
                'code' => 500,
                'message' => 'Gagal memuat data hadits',
                'data' => null
            ];
        }
    }

    /**
     * Get single hadith by number
     */
   /**
 * Get single hadith by number
 */
    public function getHadith($book, $number)
    {
        try {
            $cacheKey = "hadith_{$book}_{$number}";

            return Cache::remember($cacheKey, 3600, function () use ($book, $number) {
                $url = "{$this->baseUrl}/books/{$book}/{$number}";

                \Log::info('Single Hadith API Call: ' . $url);

                $response = Http::timeout(30)->get($url);

                if ($response->successful()) {
                    $data = $response->json();
                    \Log::info('Single Hadith API Response: ' . json_encode($data));
                    return $data;
                }

                \Log::error('Single Hadith API Failed: ' . $response->status());
                throw new Exception('Single Hadith API returned status: ' . $response->status());
            });
        } catch (Exception $e) {
            \Log::error('Get Hadith Exception: ' . $e->getMessage());
            return [
                'code' => 500,
                'message' => 'Gagal memuat detail hadits',
                'data' => null
            ];
        }
    }

    /**
     * Search hadiths
     */
   public function searchHadithsManual($query, $book = null, $limit = 50)
    {
        try {
            $cacheKey = "hadith_search_manual_" . md5($query . $book . $limit);

            return Cache::remember($cacheKey, 3600, function () use ($query, $book, $limit) {
                $results = [];

                // Jika spesifik buku, search di buku tersebut saja
                if ($book) {
                    $hadiths = $this->getHadiths($book, null, 300); // Ambil 300 hadits
                    if (isset($hadiths['data']['hadiths'])) {
                        $results = $this->searchInHadiths($hadiths['data']['hadiths'], $query, $limit);
                    }
                } else {
                    // Search di semua buku populer
                    $popularBooks = ['bukhari', 'muslim', 'abu-daud', 'tirmidzi', 'nasai', 'ibnu-majah'];

                    foreach ($popularBooks as $bookId) {
                        if (count($results) >= $limit) break;

                        $hadiths = $this->getHadiths($bookId, null, 100); // Ambil 100 hadits per buku
                        if (isset($hadiths['data']['hadiths'])) {
                            $bookResults = $this->searchInHadiths($hadiths['data']['hadiths'], $query, $limit - count($results));
                            foreach ($bookResults as $result) {
                                $result['book_id'] = $bookId;
                                $result['book_name'] = $hadiths['data']['name'] ?? $bookId;
                                $results[] = $result;
                            }
                        }
                    }
                }

                return [
                    'code' => 200,
                    'data' => [
                        'hadiths' => $results,
                        'total' => count($results),
                        'query' => $query,
                        'book' => $book
                    ]
                ];
            });
        } catch (Exception $e) {
            return [
                'code' => 500,
                'message' => 'Gagal melakukan pencarian',
                'data' => null
            ];
        }
    }

    /**
     * Search in hadiths array
     */
    private function searchInHadiths($hadiths, $query, $limit)
    {
        $results = [];
        $query = strtolower(trim($query));

        foreach ($hadiths as $hadith) {
            if (count($results) >= $limit) break;

            $arabic = $hadith['arab'] ?? '';
            $translation = strtolower($hadith['id'] ?? '');

            // Search in translation (case insensitive)
            if (strpos($translation, $query) !== false) {
                $results[] = $hadith;
            }
        }

        return $results;
    }

    /**
     * Get all hadiths from a book (for advanced search)
     */
    public function getAllHadiths($book)
    {
        try {
            $cacheKey = "hadith_all_{$book}";

            return Cache::remember($cacheKey, 86400, function () use ($book) { // Cache 24 jam
                $allHadiths = [];
                $totalHadiths = 0;

                // First, get book info to know total hadiths
                $bookInfo = $this->getHadiths($book, null, 1);
                $totalHadiths = $bookInfo['data']['available'] ?? 0;

                // Fetch in chunks of 300 (API limit)
                for ($i = 1; $i <= $totalHadiths; $i += 300) {
                    $end = min($i + 299, $totalHadiths);
                    $range = $i . '-' . $end;

                    $chunk = $this->getHadiths($book, $range);
                    if (isset($chunk['data']['hadiths'])) {
                        $allHadiths = array_merge($allHadiths, $chunk['data']['hadiths']);
                    }

                    // Break if we have enough or if taking too long
                    if (count($allHadiths) >= 1000) break; // Max 1000 hadits untuk performance
                }

                return $allHadiths;
            });
        } catch (Exception $e) {
            return [];
        }
    }
}
