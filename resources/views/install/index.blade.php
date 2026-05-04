    <!DOCTYPE html>
<html>
<head>
    <title>Installer Aplikasi Rekapitulasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-body">
                <h3 class="text-center mb-4">Setup Database Hosting</h3>
                <form action="{{ route('install.setup') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Database (cPanel)</label>
                        <input type="text" name="db_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username Database</label>
                        <input type="text" name="db_user" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Pasang Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>