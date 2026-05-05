<?php

namespace App\Http\Controllers;

use App\Models\WorkReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Konfigurasi Kategori Spesifik per Jabatan [cite: 153]
    private function getCategories($role) {
        $allCategories = [
            'laboran' => [
                'persiapan' => 'Persiapan Ruang, Alat dan Bahan Praktikum',
                'klasifikasi' => 'Pencatatan Klasifikasi Peralatan',
                'pelayanan' => 'Pelayanan Kegiatan Praktikum',
                'perawatan' => 'Perawatan Peralatan Alat',
                'keamanan' => 'Prosedur Keamanan'
            ],
            'perpustakaan' => [
                'pengolahan' => 'Pengolahan bahan pustaka (Pengecapan, Label, Katalog)',
                'perawatan' => 'Perawatan koleksi dan perbaikan kerusakan',
                'sirkulasi' => 'Pelayanan sirkulasi (Peminjaman & Pengembalian)',
                'operasional' => 'Pengaturan operasional dan jam layanan',
                'referensi' => 'Membantu mencari bahan referensi'
            ],
            // Kategori untuk Kepegawaian, Persuratan, Keuangan, Kesiswaan, Dapodik [cite: 138]
            'umum' => [
                'administrasi' => 'Pelaksanaan tugas administrasi (Kepegawaian, Keuangan, dll)',
                'update_data' => 'Pengolahan dan pemuktahiran data satuan pendidikan',
                'bantuan_kegiatan' => 'Perbantuan pelaksanaan kegiatan satuan pendidikan',
                'persuratan' => 'Persuratan (Konsep, Stempel, Arsip, dll)',
                'pelayanan' => 'Pelayanan masyarakat dan peserta didik'
            ]
        ];

        if ($role === 'laboran') return $allCategories['laboran'];
        if ($role === 'perpustakaan') return $allCategories['perpustakaan'];
        return $allCategories['umum'];
    }

    public function dashboardUtama() {
        $roles = [
            'laboran' => 'Laboran',
            'kepegawaian' => 'Kepegawaian',
            'persuratan' => 'Persuratan',
            'keuangan' => 'Keuangan',
            'kesiswaan' => 'Kesiswaan',
            'dapodik' => 'Dapodik',
            'perpustakaan' => 'Perpustakaan'
        ];
        return view('reports.dashboard_utama', compact('roles'));
    }

    public function dashboardJabatan($role) {
        if (strtolower(auth()->user()->role) !== strtolower($role)) {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)])
                             ->with('error', 'Anda tidak memiliki akses ke jabatan tersebut.');
        }
        return view('reports.dashboard_jabatan', compact('role'));
    }

    public function inputPage($role) {
        if (strtolower(auth()->user()->role) !== strtolower($role)) {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)]);
        }
        $categories = $this->getCategories($role);
        $recentData = WorkReport::where('role', $role)->latest()->take(5)->get();
        return view('reports.input', compact('role', 'categories', 'recentData'));
    }

    public function cetakPage($role) {
        if (strtolower(auth()->user()->role) !== strtolower($role)) {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)]);
        }
        $categories = $this->getCategories($role);
        return view('reports.cetak', compact('role', 'categories'));
    }

    public function store(Request $request) {
    // Validasi file (Opsional, Maks 2MB)
    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->all();

    // Logika simpan gambar jika ada file yang diunggah
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('reports', $filename, 'public');
        $data['image'] = $filename;
    } 
    // Logika simpan gambar dari kamera (Base64)
    elseif ($request->filled('captured_image')) {
        $img = $request->input('captured_image');
        $img = preg_replace('#^data:image/\w+;base64,#i', '', $img);
        $img = str_replace(' ', '+', $img);
        $imageData = base64_decode($img);
        
        if ($imageData) {
            $filename = time() . '_captured.jpg';
            $path = storage_path('app/public/reports/' . $filename);
            
            // Pastikan folder ada
            if (!file_exists(storage_path('app/public/reports'))) {
                mkdir(storage_path('app/public/reports'), 0777, true);
            }

            file_put_contents($path, $imageData);
            $data['image'] = $filename;
        }
    }

    $data['nama'] = auth()->user()->name;
    $data['role'] = strtoupper($request->role);

    WorkReport::create($data);
    return back()->with('success', 'Data berhasil disimpan!');
}
    public function edit($id) {
    $report = WorkReport::findOrFail($id);
    $role = $report->role;
    $categories = $this->getCategories($role); // Mengambil kategori sesuai jabatan [cite: 165]
    
    return view('reports.edit', compact('report', 'role', 'categories'));
}

public function update(Request $request, $id) {
    $report = WorkReport::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image') || $request->filled('captured_image')) {
        // Hapus file lama jika ada
        if ($report->image && \Storage::disk('public')->exists('reports/' . $report->image)) {
            \Storage::disk('public')->delete('reports/' . $report->image);
        }

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048']);
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('reports', $filename, 'public');
            $data['image'] = $filename;
        } elseif ($request->filled('captured_image')) {
            $img = $request->input('captured_image');
            $img = preg_replace('#^data:image/\w+;base64,#i', '', $img);
            $img = str_replace(' ', '+', $img);
            $imageData = base64_decode($img);

            if ($imageData) {
                $filename = time() . '_captured.jpg';
                $path = storage_path('app/public/reports/' . $filename);
                
                if (!file_exists(storage_path('app/public/reports'))) {
                    mkdir(storage_path('app/public/reports'), 0777, true);
                }

                file_put_contents($path, $imageData);
                $data['image'] = $filename;
            }
        }
    }

    $report->update($data);
    
    return redirect()->route('reports.input', $report->role)->with('success', 'Data berhasil diperbarui!');
}

public function destroy($id) {
    $report = WorkReport::findOrFail($id);
    $report->delete();
    
    return back()->with('success', 'Data berhasil dihapus!');
}


    public function exportPdf(Request $request, $role, $category) {
        $categories = $this->getCategories($role);
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

        $data = WorkReport::where('role', $role)
            ->where('category', $category)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'asc')
            ->get();

        $title = "REKAPITULASI " . strtoupper($categories[$category] ?? 'LAPORAN');
        $nama_bulan = date('F', mktime(0, 0, 0, $month, 10));

        $nama_pegawai = $data->first()->nama ?? auth()->user()->name;
        $pdf = Pdf::loadView('reports.pdf_template', compact('data', 'title', 'nama_bulan', 'year', 'nama_pegawai'));

        $category_name = strtoupper($categories[$category] ?? $category);
        $filename = "HASIL KERJA_REKAPITULASI_{$category_name}_{$nama_bulan}.pdf";

        if ($request->has('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}