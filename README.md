# 📊 Aplikasi Rekapitulasi Kinerja (ARK) - SMK Negeri 2 Konoha `v1.2.5`

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 🎯 Tujuan Aplikasi
Aplikasi Rekapitulasi Kinerja (ARK) dirancang untuk mentransformasi sistem pelaporan kinerja manual menjadi platform digital yang efisien, transparan, dan akuntabel. Aplikasi ini bertujuan untuk mendokumentasikan setiap aktivitas harian pegawai secara sistematis guna memudahkan proses pemantauan (monitoring) dan evaluasi kinerja tahunan.

## 👥 Target Pengguna
1.  **PPPK Paruh Waktu Tenaga Kependidikan (TENDIK)**: Sebagai pengguna utama untuk menginput laporan kinerja harian dan mengunduh rekapitulasi bulanan. Mencakup jabatan:
    *   🔬 **Laboran**
    *   📚 **Perpustakaan**
    *   👤 **Kepegawaian**
    *   📩 **Persuratan**
    *   💰 **Keuangan**
    *   👨‍🎓 **Kesiswaan**
    *   💻 **Dapodik**
2.  **Super Admin**: Sebagai pengawas otoritas penuh untuk memantau produktivitas staf TENDIK, mengelola akun pengguna, dan konfigurasi sistem.

---

## ✨ Fitur Unggulan
*   **White Label System**: Branding dinamis (Logo, Nama Sekolah, Warna Tema) yang bisa diubah langsung dari Dashboard Admin.
*   **Daily Work Report**: Input aktivitas harian yang cepat dan responsif.
*   **Manajemen User**: Kontrol penuh terhadap akun pegawai dan fitur reset password.
*   **Security Management**: Sistem ganti password mandiri untuk seluruh pengguna.
*   **Auto-Installer**: Memudahkan proses migrasi database saat pertama kali aplikasi di-deploy ke hosting.

---

## 🚀 Panduan Instalasi

### Prasyarat
*   PHP >= 8.2
*   MySQL / MariaDB
*   Apache / Nginx

### Langkah-langkah
1.  **Clone Repositori**
    ```bash
    git clone https://github.com/ridyko/AplikasiHasilKinerjaPPPK-PW.git
    ```
2.  **Konfigurasi Dasar**
    Salin file `.env.example` menjadi `.env` dan atur `APP_KEY` menggunakan:
    ```bash
    php artisan key:generate
    ```
3.  **Setup via Browser**
    Akses URL berikut untuk melakukan konfigurasi database dan aktivasi sistem:
    ```text
    http://domain-anda.com/install
    ```
4.  **Optimasi (Opsional)**
    Setelah instalasi, jalankan perintah ini jika berada di lingkungan hosting:
    ```bash
    php artisan optimize:clear
    php artisan storage:link
    ```

---

## 🔐 Logika Aktivasi (Teknis)
Aplikasi ini dilengkapi dengan sistem perlindungan domain melalui **Activation Key**. Berikut adalah rumusan teknis untuk keperluan pemeliharaan (maintenance):

*   **Algoritma**: MD5 Hashing
*   **Parameter**: `Domain_Name` + `Secret_Salt`
*   **Secret Salt**: `KONOHA_SECRET_2024`
*   **Rumus**:
    ```text
    APP_LICENSE_KEY = MD5(request->getHost() . "KONOHA_SECRET_2024")
    ```
*Catatan: Pastikan License Key ini terdaftar di file `.env` agar aplikasi dapat berjalan di domain yang dituju.*

---

## 🛠️ Log Perbaikan & Update Terbaru (Mei 2026)

Berikut adalah daftar peningkatan yang telah diimplementasikan untuk meningkatkan fungsionalitas dan pengalaman pengguna:

1.  **Integrasi Webcam Capture**: Implementasi pengambilan foto bukti laporan secara langsung melalui kamera laptop/HP (Webcam) menggunakan Canvas API.
2.  **Dual-Camera Switching**: Penambahan fitur ganti kamera (Depan/Belakang) untuk pengguna mobile guna memudahkan pengambilan foto bukti kerja.
3.  **Sistem Sinkronisasi Database (Hotfix)**: Pembuatan rute `/fix-database-hosting` untuk melakukan migrasi kolom `nama` dan `keterangan` secara dinamis pada server hosting tanpa merusak data yang sudah ada.
4.  **Optimasi Penamaan File PDF**: Perubahan format nama file download rekap menjadi `HASIL KERJA_REKAPITULASI_[Kategori]_[Bulan].pdf` untuk kemudahan pengarsipan.
5.  **Peningkatan Responsivitas UI**: Redesain tabel riwayat dan form input agar lebih ramah pengguna (user-friendly) di perangkat seluler dengan estetika premium.
6.  **Perbaikan Izin Akses (Permissions)**: Solusi izin akses folder `storage` pada lingkungan XAMPP macOS untuk menjamin kelancaran penyimpanan log dan gambar.
7.  **Reset Akun Administrator**: Pemulihan akses dashboard melalui reset password masal dan konfigurasi ulang database lokal.

---

## 📜 Riwayat Versi (Versioning)

| Versi | Status | Deskripsi |
| :--- | :--- | :--- |
| **v1.2.5** | **Current** | Penambahan fitur Kamera (Depan/Belakang), Perbaikan Database Hosting, & Optimasi Nama File PDF. |
| **v1.2.0** | Stable | Penambahan fitur Export PDF Professional & Sistem Installer Otomatis. |
| **v1.1.0** | Stable | Implementasi Dashboard Admin, Manajemen User, & Sistem Multi-Jabatan. |
| **v1.0.0** | Initial | Rilis awal sistem input laporan kinerja harian. |

---

## 📄 Lisensi
Sistem ini dikembangkan secara eksklusif untuk **SMK Negeri 2 Konoha**. Penggunaan di luar lingkungan instansi tersebut tanpa izin pengembang sangat dilarang.

**Dikembangkan dengan ❤️ oleh Ridyko.**
