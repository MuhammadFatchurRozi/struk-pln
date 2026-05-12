<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\pelanggan as Pelanggan;
use App\Models\mutasi_struk ;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class StrukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list_periode = mutasi_struk::select('periode')
                ->groupBy('periode')
                ->orderBy('periode', 'desc') // Urutkan berdasarkan periode
                ->get();

        $query = mutasi_struk::with('pelanggan')->latest();

        // Filter Periode
        if ($request->filled('filter_periode')) {
            $query->where('periode', $request->filter_periode);
        }

        $mutasi = $query->paginate(10);

        // Hitung Total untuk Card Ringkasan (Hanya jika filter aktif)
        $total_periode = 0;
        if ($request->filled('filter_periode')) {
            $total_periode = mutasi_struk::where('periode', $request->filter_periode)
                            ->selectRaw('SUM(tagihan + biaya_admin) as total')
                            ->first()->total;
        }

        return view('index', compact('mutasi', 'list_periode', 'total_periode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periode = strtoupper(Carbon::now()->format('My'));
        
        // Ambil semua pelanggan dan muat relasi mutasi khusus untuk periode ini saja
        $pelanggan = Pelanggan::with(['mutasi' => function($query) use ($periode) {
            $query->where('periode', $periode);
        }])->get();
        
        $admin = $pelanggan->first()?->mutasi?->first()?->biaya_admin ?? 2500; // Ambil biaya admin dari data mutasi pertama, atau default 2500 jika tidak ada
        
        return view('create_struk', compact('periode', 'pelanggan', 'admin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $periode = $request->periode;
        $tags = $request->tags;
        $admin = $request->admin_global;

        // --- LOGIKA: TOMBOL LANGSUNG CETAK (Cetak Berdasarkan Periode) ---
        if ($request->mode_cetak_saja == 'yes') {
            // Ambil data dari database berdasarkan periode yang sedang aktif di page tersebut
            $data = mutasi_struk::with('pelanggan')
                    ->where('periode', $periode)
                    ->get();

            // Jika data kosong, beri peringatan untuk simpan dulu
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', "Data periode $periode tidak ditemukan. Silakan klik 'Simpan & Cetak' terlebih dahulu.");
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf_struk', compact('data'))
                ->setPaper('a4', 'portrait');
            
            return $pdf->stream('Struk_PLN_' . $periode . '.pdf');
        }

        // --- LOGIKA: TOMBOL SIMPAN & CETAK ---
        if ($request->overwrite == 'yes') {
            mutasi_struk::where('periode', $periode)
                        ->whereIn('pelanggan_id', array_keys($tags))
                        ->delete();
        }

        $insertedIds = [];
        foreach ($tags as $idpel => $nominal) {
            if (!empty($nominal) && $nominal > 0) {
                // Validasi double input jika tidak overwrite
                $exists = mutasi_struk::where('pelanggan_id', $idpel)
                                    ->where('periode', $periode)
                                    ->exists();

                if (!$exists) {
                    $mutasi = mutasi_struk::create([
                        'pelanggan_id' => $idpel,
                        'periode'      => $periode,
                        'tagihan'      => $nominal,
                        'biaya_admin'  => $admin,
                    ]);
                    $insertedIds[] = $mutasi->id;
                }
            }
        }

        if (empty($insertedIds) && $request->overwrite != 'yes') {
            return redirect()->back()->with('error', 'Data sudah ada. Gunakan Simpan Ulang untuk memperbarui.');
        }

        // Jika overwrite dan berhasil simpan ulang, ambil semua data periode tersebut untuk dicetak
        $dataToPrint = empty($insertedIds) 
            ? mutasi_struk::with('pelanggan')->where('periode', $periode)->get()
            : mutasi_struk::with('pelanggan')->whereIn('id', $insertedIds)->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf_struk', ['data' => $dataToPrint])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Struk_PLN_' . $periode . '.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show($insertedIds)
    {
        // Ambil data mutasi yang baru saja dibuat beserta relasi pelanggannya
        // Gunakan 'pelanggan' (nama relasi di model mutasi_struk)
        $data = mutasi_struk::with('pelanggan')->whereIn('id', $insertedIds)->get();

        // Load view PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf_struk', compact('data'))
            ->setPaper('a4', 'portrait');

        // Menampilkan PDF di browser (langsung bisa diprint)
        return $pdf->stream('Struk_PLN_' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

    public function generatePDF(Request $request) {
        // Validasi Input
        $request->validate([
            'data.*.idpel' => 'required',
            'data.*.nama' => 'required',
            'data.*.biaya_pln' => 'required|numeric',
            'data.*.admin' => 'required|numeric',
        ]);

        $dataStruk = $request->input('data');

        // Hitung total dan terbilang secara otomatis
        foreach ($dataStruk as &$item) {
            $item['total'] = (int)$item['biaya_pln'] + (int)$item['admin'];
            $item['terbilang_teks'] = NumberHelper::terbilang($item['total']);
            // Format stand meter jika dipisah
            $item['stand_meter'] = $item['stand_awal'] . '-' . $item['stand_akhir'];
        }

        $pdf = Pdf::loadView('pdf.struk', compact('dataStruk'));
        return $pdf->stream('struk-pln-multi.pdf');
    }

    public function getPreviousData(Request $request) {
        // Fungsi untuk mengambil data dari periode sebelumnya (Ajax)
        $periodeLalu = $request->periode_lalu; 
        return MutasiStruk::with('pelanggan')
                        ->where('periode', $periodeLalu)
                        ->get();
    }
}
