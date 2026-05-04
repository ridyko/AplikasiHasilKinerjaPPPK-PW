<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kinerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 40px 0; }
        .main-card { background: rgba(255, 255, 255, 0.95); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); padding: 30px; }
        .form-section { background: #f8f9fa; border-radius: 15px; padding: 20px; margin-bottom: 25px; border-left: 5px solid #667eea; }
        .btn-download { background: #ff4757; color: white; border-radius: 8px; padding: 8px 15px; font-size: 0.9rem; transition: 0.3s; cursor: pointer; }
        .btn-download:hover { background: #e84118; box-shadow: 0 5px 15px rgba(255,71,87,0.3); }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-card">
                <div class="text-center mb-4">
                    <h2>📊 Aplikasi Isi Hasil Kinerja</h2>
                    <p class="text-muted">Simpan tugas harian dan unduh laporan per bulan secara otomatis.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif

                <div class="form-section">
                    <h5 class="mb-3">Tambah Data Pekerjaan</h5>
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Kategori</label>
                                <select name="category" class="form-select" required>
                                    @foreach($categories as $key => $name)
                                        <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Uraian Tugas</label>
                                <input type="text" name="uraian_tugas" class="form-control" placeholder="Tuliskan aktivitas..." required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="form-section shadow-sm mt-4">
                    <h5 class="mb-3 text-primary">Cetak Laporan Bulanan</h5>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Pilih Bulan</label>
                            <select id="filter_month" class="form-select">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ date('m') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Pilih Tahun</label>
                            <select id="filter_year" class="form-select">
                                @foreach(range(date('Y')-2, date('Y')+2) as $y)
                                    <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Jenis Laporan Rekapitulasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $key => $name)
                                <tr>
                                    <td class="ps-3 fw-bold text-dark">REKAPITULASI {{ strtoupper($name) }}</td>
                                    <td class="text-center">
                                        <button onclick="downloadWithFilter('{{ $key }}')" class="btn-download border-0">
                                            📥 Download PDF
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function downloadWithFilter(category) {
        const month = document.getElementById('filter_month').value;
        const year = document.getElementById('filter_year').value;
        window.location.href = `/export-pdf/${category}?month=${month}&year=${year}`;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>