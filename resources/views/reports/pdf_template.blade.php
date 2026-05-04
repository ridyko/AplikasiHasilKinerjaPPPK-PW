<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 25px; font-weight: bold; text-transform: uppercase; }
        .employee-info { text-align: left; margin-bottom: 10px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; table-layout: fixed; }
        th, td { border: 1px solid black; padding: 8px; word-wrap: break-word; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        /* Styling khusus gambar agar tidak merusak tata letak tabel */
        .img-report { width: 80px; height: auto; border: 1px solid #ddd; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        {{ $title }}<br>
        PERIODE: {{ strtoupper($nama_bulan) }} {{ $year }}
    </div>

    <div class="employee-info">
        NAMA : {{ strtoupper($nama_pegawai) }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">TANGGAL</th>
                <th width="40%">URAIAN TUGAS</th>
                <th width="20%">GAMBAR</th>
                <th width="25%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr>
                <td class="text-center">{{ date('d/m/Y', strtotime($row->tanggal)) }}</td>
                <td>{{ $row->uraian_tugas }}</td>
                <td class="text-center">
                    @if($row->image)
                        {{-- Menggunakan public_path agar DomPDF bisa mengakses file secara lokal --}}
                        <img src="{{ public_path('storage/reports/' . $row->image) }}" class="img-report">
                    @else
                        <span style="color: #999;">-</span>
                    @endif
                </td>
                <td class="text-center">{{ $row->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>