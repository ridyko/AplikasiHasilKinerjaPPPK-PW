<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kinerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .menu-card { background: white; border-radius: 20px; transition: 0.3s; cursor: pointer; text-decoration: none; color: #333; padding: 40px; text-align: center; height: 100%; }
        .menu-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
<div class="container text-center text-white">
    <h1 class="mb-5 fw-bold">📊 Aplikasi Isi Hasil Kinerja</h1>
    <h2 class="mb-5 fw-bold">LABORAN</h2>
    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <a href="{{ route('reports.input') }}" class="menu-card d-block shadow border-0">
                <div class="display-1 mb-3">📝</div>
                <h3 class="fw-bold">Input Data</h3>
                <p class="text-muted">Tambah laporan pekerjaan harian Anda.</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('reports.cetak') }}" class="menu-card d-block shadow border-0">
                <div class="display-1 mb-3">📄</div>
                <h3 class="fw-bold">Cetak Laporan</h3>
                <p class="text-muted">Unduh rekapitulasi bulanan dalam PDF.</p>
            </a>
        </div>
    </div>
</div>
</body>
</html>