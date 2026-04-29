# SPK Pemilihan Karyawan Terbaik - Metode SAW

Aplikasi Sistem Pendukung Keputusan (SPK) untuk menentukan karyawan terbaik menggunakan metode **Simple Additive Weighting (SAW)**. Aplikasi ini dibangun menggunakan framework Laravel dan Bootstrap.

## Fitur Utama

- **Dashboard**: Ringkasan data sistem.
- **Manajemen Kriteria**: Tambah, edit, dan hapus kriteria beserta bobot dan tipenya (Benefit/Cost).
- **Manajemen Karyawan**: Pengelolaan data karyawan/alternatif.
- **Input Nilai**: Input nilai karyawan untuk setiap kriteria yang telah ditentukan.
- **Perhitungan SAW**:
    - Matriks Normalisasi (R)
    - Matriks Terbobot (Y) - _Disesuaikan dengan pembulatan presisi Excel_
    - Hasil Akhir & Ranking (V)
- **UI Modern**: Menggunakan Bootstrap 5 dengan Sidebar Sticky dan animasi smooth.

## Prasyarat

Sebelum menginstal, pastikan komputer Anda sudah terinstal:

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB

## Langkah Instalasi

1. **Clone Repository**

    ```bash
    git clone https://github.com/dheandi/KaryawanTerbaik-SAW.git
    cd KaryawanTerbaik-SAW
    ```

2. **Install Dependency PHP**

    ```bash
    composer install
    ```

3. **Install Dependency JavaScript**

    ```bash
    npm install
    npm run dev
    ```

4. **Setup Environment File**
   Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan konfigurasi database Anda:

    ```env
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Migrasi dan Seed Database**
   Perintah ini akan membuat tabel dan mengisi data awal (Admin & Kriteria):

    ```bash
    php artisan migrate --seed
    ```

7. **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Buka `http://127.0.0.1:8000` di browser Anda.

## Akun Default (Seeder)

- **Email**: `admin@gmail.com`
- **Password**: `password`

## Lisensi

Aplikasi ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
