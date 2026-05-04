# 📊 Aplikasi Rekapitulasi Kinerja (ARK) - SMK Negeri 2 Konoha

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 🎯 Tujuan Aplikasi
Aplikasi Rekapitulasi Kinerja (ARK) dirancang untuk mentransformasi sistem pelaporan kinerja manual menjadi platform digital yang efisien, transparan, dan akuntabel. Aplikasi ini bertujuan untuk mendokumentasikan setiap aktivitas harian pegawai secara sistematis guna memudahkan proses pemantauan (monitoring) dan evaluasi kinerja tahunan.

## 👥 Target Pengguna
1.  **Guru & Pegawai (PPPK/Honorer)**: Untuk menginput laporan aktivitas kerja harian dan mencetak rekapitulasi bulanan.
2.  **Administrator/Kepala Sekolah**: Untuk memantau produktivitas seluruh staf, mengelola akun pengguna, dan melakukan kustomisasi branding instansi.

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

## 📄 Lisensi
Sistem ini dikembangkan secara eksklusif untuk **SMK Negeri 2 Konoha**. Penggunaan di luar lingkungan instansi tersebut tanpa izin pengembang sangat dilarang.

**Dikembangkan dengan ❤️ oleh Ridyko.**
