<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data buku dari database
        $bukus = Buku::latest()->get();

        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // Data untuk dropdown (tambahan)
        $kategoris = Buku::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->pluck('tahun_terbit');

        // Return view dengan data
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoris',  // Tambahan
            'tahuns'      // Tambahan
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ........
        $buku = Buku::findOrFail($id);

        //........
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori'
        ));
    }

    /**
     * Search dan filter buku berdasarkan multiple kriteria
     * 
     * Method ini menerima input dari form search dan membangun query
     * secara dinamis berdasarkan filter yang diisi user
     * 
     * @param Request $request - Object request berisi input dari form
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // ========== INISIALISASI QUERY BUILDER ==========

        // Membuat query builder instance
        // query() mengembalikan Eloquent Builder, bukan hasil query
        $query = Buku::query();


        // ========== FILTER KEYWORD (SEARCH) ==========

        // Ambil input keyword dari form
        $keyword = $request->input('keyword');

        // Jika keyword diisi, cari di 3 kolom: judul, pengarang, penerbit
        if ($keyword) {
            // where() dengan closure untuk grouping kondisi OR
            $query->where(function ($q) use ($keyword) {
                // LIKE '%keyword%' = mencari substring di kolom
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%");
            });

            // Query SQL yang dihasilkan:
            // WHERE (judul LIKE '%keyword%' OR pengarang LIKE '%keyword%' OR penerbit LIKE '%keyword%')
        }


        // ========== FILTER KATEGORI ==========

        // Ambil input kategori dari dropdown
        $kategori = $request->input('kategori');

        // Jika kategori dipilih (bukan "Semua")
        if ($kategori) {
            // Tambahkan kondisi WHERE kategori = value
            $query->where('kategori', $kategori);

            // Query SQL: WHERE kategori = 'Programming'
        }


        // ========== FILTER TAHUN ==========

        // Ambil input tahun dari dropdown
        $tahun = $request->input('tahun');

        // Jika tahun dipilih
        if ($tahun) {
            // Tambahkan kondisi WHERE tahun_terbit = value
            $query->where('tahun_terbit', $tahun);

            // Query SQL: WHERE tahun_terbit = 2024
        }


        // ========== FILTER KETERSEDIAAN ==========

        // Ambil input ketersediaan dari dropdown
        $ketersediaan = $request->input('ketersediaan');

        // Filter berdasarkan stok
        if ($ketersediaan === 'tersedia') {
            // Buku dengan stok > 0
            $query->where('stok', '>', 0);

            // Query SQL: WHERE stok > 0
        } elseif ($ketersediaan === 'habis') {
            // Buku dengan stok = 0
            $query->where('stok', 0);

            // Query SQL: WHERE stok = 0
        }
        // Jika 'semua' atau tidak diisi, tidak ada filter stok


        // ========== EKSEKUSI QUERY ==========

        // latest() = orderBy('created_at', 'desc')
        // get() = eksekusi query dan ambil hasil
        $bukus = $query->latest()->get();


        // ========== STATISTIK ==========

        // Hitung statistik dari hasil filter
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();


        // ========== DATA UNTUK DROPDOWN ==========

        // Ambil semua kategori unik dari database
        $kategoris = Buku::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        // Ambil semua tahun unik dari database
        $tahuns = Buku::select('tahun_terbit')
            ->distinct()
            ->orderBy('tahun_terbit', 'desc')
            ->pluck('tahun_terbit');


        // ========== KIRIM DATA KE VIEW ==========

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoris',
            'tahuns',
            'keyword',      // Untuk mengisi kembali form
            'kategori',     // Untuk mengisi kembali form
            'tahun',        // Untuk mengisi kembali form
            'ketersediaan'  // Untuk mengisi kembali form
        ));
    }
}
