<h1 align="center">Aksa Media Backend</h1>

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<p align="center">
Backend service untuk aplikasi <strong>Aksa Media</strong>, dibangun menggunakan framework Laravel.
</p>

<p align="center">
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-^8.1-blue.svg" alt="PHP Version"></a>
</p>

---

## 📑 Table of Contents
- [1. Tentang Proyek](#1-tentang-proyek)
- [2. Teknologi & Komponen Utama](#2-teknologi--komponen-utama)
- [3. Struktur Proyek](#3-struktur-proyek)
- [4. Instalasi & Setup](#4-instalasi--setup)
- [5. Autentikasi](#5-autentikasi)
- [6. Dokumentasi Endpoint API](#6-dokumentasi-endpoint-api)
- [7. Penanganan Error](#7-penanganan-error)
- [8. Pengujian](#8-pengujian)
- [9. Deployment](#9-deployment)
- [10. Lisensi](#10-lisensi)
- [11. Kontak](#11-kontak)

## 1. Tentang Proyek
**Aksa Media Backend** adalah layanan RESTful API yang menjadi tulang punggung aplikasi Aksa Media. Proyek ini berfungsi sebagai server yang menangani:
- **Autentikasi Pengguna**: Mengelola proses login dan logout untuk admin.
- **Manajemen Data**: Menyediakan operasi CRUD (Create, Read, Update, Delete) untuk data master seperti Divisi dan Karyawan.
- **Keamanan**: Menggunakan Laravel Sanctum untuk melindungi endpoint API.

## 2. Teknologi & Komponen Utama
- **Framework**: [Laravel 10.x](https://laravel.com/)
- **Bahasa**: PHP 8.1+
- **Database**: MySQL / MariaDB / PostgreSQL
- **Autentikasi**: [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum)
- **Dependency Management**: Composer
- **Data Seeding**: [FakerPHP](https://fakerphp.github.io/)
- **Pengujian**: PHPUnit

## 3. Struktur Proyek
Proyek ini mengikuti struktur direktori standar Laravel:

- `app/`: Berisi logika inti aplikasi, termasuk Models, Controllers, dan Providers.
  - `Http/Controllers/Api/`: Controller yang menangani request API.
- `config/`: File konfigurasi untuk berbagai layanan aplikasi.
- `database/`: Migrasi, seeder, dan factory untuk database.
- `routes/`: Definisi rute aplikasi.
  - `api.php`: Rute khusus untuk API.
- `tests/`: Berisi semua file pengujian (unit dan feature).

## 4. Instalasi & Setup

### Prasyarat
- PHP ^8.1
- Composer
- Database Server (MySQL, MariaDB, atau PostgreSQL)
- Git

### Langkah-langkah Instalasi
1.  **Clone repository:**
    ```bash
    git clone https://github.com/username/aksamedia-backend.git
    cd aksamedia-backend
    ```

2.  **Install dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Buat file environment:**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Generate kunci aplikasi:**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi database:**
    Buka file `.env` dan sesuaikan konfigurasi database Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=aksamedia
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan migrasi database:**
    Perintah ini akan membuat tabel-tabel yang dibutuhkan di database.
    ```bash
    php artisan migrate
    ```

7.  **(Opsional) Jalankan seeder:**
    Perintah ini akan mengisi database dengan data dummy untuk pengembangan.
    ```bash
    php artisan db:seed
    ```

### Menjalankan Server Lokal
Jalankan server pengembangan Laravel menggunakan Artisan.
```bash
php artisan serve
```
Secara default, API akan dapat diakses di `http://127.0.0.1:8000`.

## 5. Autentikasi
API ini menggunakan **Laravel Sanctum** untuk autentikasi berbasis token. Untuk mengakses endpoint yang terproteksi, Anda harus menyertakan token API pada header `Authorization`.

**Alur Autentikasi:**
1.  Kirim request `POST` ke endpoint `/api/login` dengan `username` dan `password`.
2.  Jika kredensial valid, API akan mengembalikan token API.
3.  Gunakan token ini sebagai **Bearer Token** pada header `Authorization` untuk setiap request ke endpoint yang memerlukan autentikasi.

**Contoh Header:**
```
Authorization: Bearer <YOUR_API_TOKEN>
Accept: application/json
```

## 6. Dokumentasi Endpoint API

### 6.1. Autentikasi

#### Login Admin
- **Endpoint**: `POST /api/login`
- **Deskripsi**: Mengautentikasi admin dan mengembalikan token API.
- **Request Body**:
  ```json
  {
      "username": "admin_username",
      "password": "your_password"
  }
  ```
- **Contoh cURL**:
  ```bash
  curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"username": "admin", "password": "password"}'
  ```
- **Response Sukses (200 OK)**:
  ```json
  {
      "status": "success",
      "message": "Login success",
      "data": {
          "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...",
          "admin": {
              "id": 1,
              "name": "Administrator",
              "username": "admin",
              "phone": "081234567890",
              "email": "admin@example.com"
          }
      }
  }
  ```

#### Logout Admin
- **Endpoint**: `POST /api/logout`
- **Deskripsi**: Menghapus token API pengguna yang sedang login.
- **Headers**: `Authorization: Bearer <token>`
- **Contoh cURL**:
  ```bash
  curl -X POST http://127.0.0.1:8000/api/logout \
  -H "Authorization: Bearer <YOUR_API_TOKEN>" \
  -H "Accept: application/json"
  ```
- **Response Sukses (200 OK)**:
  ```json
  {
      "status": "success",
      "message": "Logout success"
  }
  ```

---

### 6.2. Divisi (Divisions)
Semua endpoint di bawah ini memerlukan autentikasi.

#### `GET /api/divisions`
- **Deskripsi**: Mendapatkan daftar semua divisi.
- **Response Sukses (200 OK)**:
  ```json
  {
      "data": [
          {"id": 1, "name": "IT", "created_at": "...", "updated_at": "..."},
          {"id": 2, "name": "Human Resources", "created_at": "...", "updated_at": "..."}
      ]
  }
  ```

#### `POST /api/divisions`
- **Deskripsi**: Membuat divisi baru.
- **Request Body**:
  ```json
  {
      "name": "Marketing"
  }
  ```
- **Response Sukses (201 Created)**:
  ```json
  {
      "data": {
          "id": 3,
          "name": "Marketing",
          "created_at": "...",
          "updated_at": "..."
      }
  }
  ```

#### `GET /api/divisions/{id}`
- **Deskripsi**: Mendapatkan detail satu divisi berdasarkan ID.
- **Response Sukses (200 OK)**:
  ```json
  {
      "data": {
          "id": 1,
          "name": "IT",
          "created_at": "...",
          "updated_at": "..."
      }
  }
  ```

#### `PUT /api/divisions/{id}`
- **Deskripsi**: Memperbarui data divisi.
- **Request Body**:
  ```json
  {
      "name": "Information Technology"
  }
  ```
- **Response Sukses (200 OK)**:
  ```json
  {
      "data": {
          "id": 1,
          "name": "Information Technology",
          "created_at": "...",
          "updated_at": "..."
      }
  }
  ```

#### `DELETE /api/divisions/{id}`
- **Deskripsi**: Menghapus divisi.
- **Response Sukses (204 No Content)**: Tidak ada body response.

---

### 6.3. Karyawan (Employees)
Semua endpoint di bawah ini memerlukan autentikasi.

#### `GET /api/employees`
- **Deskripsi**: Mendapatkan daftar semua karyawan.

#### `POST /api/employees`
- **Deskripsi**: Membuat data karyawan baru.
- **Request Body**: (Asumsi, sesuaikan dengan implementasi)
  ```json
  {
      "name": "John Doe",
      "email": "john.doe@example.com",
      "division_id": 1
  }
  ```

#### `GET /api/employees/{id}`
- **Deskripsi**: Mendapatkan detail satu karyawan berdasarkan ID.

#### `PUT /api/employees/{id}`
- **Deskripsi**: Memperbarui data karyawan.

#### `DELETE /api/employees/{id}`
- **Deskripsi**: Menghapus data karyawan.

## 7. Penanganan Error
API menggunakan kode status HTTP standar untuk mengindikasikan keberhasilan atau kegagalan request.

| Kode Status | Deskripsi | Contoh Body Response |
| :--- | :--- | :--- |
| `200 OK` | Request berhasil. | `{ "data": [...] }` |
| `201 Created` | Resource berhasil dibuat. | `{ "data": {...} }` |
| `204 No Content` | Request berhasil, tidak ada body response. | (kosong) |
| `400 Bad Request` | Request tidak valid (misal: kredensial salah). | `{ "status": "error", "message": "Invalid username or password" }` |
| `401 Unauthorized` | Autentikasi gagal atau tidak ada. | `{ "message": "Unauthenticated." }` |
| `404 Not Found` | Resource yang diminta tidak ditemukan. | `{ "message": "Not Found" }` |
| `422 Unprocessable` | Validasi gagal (data yang dikirim tidak sesuai). | `{ "message": "The given data was invalid.", "errors": {...} }` |
| `500 Server Error` | Terjadi kesalahan di server. | `{ "message": "Server Error" }` |

## 8. Pengujian
Proyek ini dilengkapi dengan PHPUnit untuk pengujian. Untuk menjalankan semua test suite, gunakan perintah Artisan berikut:
```bash
php artisan test
```

## 9. Deployment
Berikut adalah langkah-langkah umum untuk mendeploy aplikasi Laravel:
1.  Pastikan server Anda memenuhi prasyarat Laravel.
2.  Konfigurasi web server (Nginx/Apache) agar document root menunjuk ke direktori `public/` proyek.
3.  Unggah file proyek ke server.
4.  Buat file `.env` untuk lingkungan produksi dan isi dengan konfigurasi yang sesuai (`APP_ENV=production`, `APP_DEBUG=false`, koneksi database, dll.).
5.  Jalankan perintah berikut di terminal server:
    ```bash
    composer install --optimize-autoloader --no-dev
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan migrate --force
    ```
6.  Pastikan permission folder `storage` dan `bootstrap/cache` sudah benar.

## 10. Lisensi
Proyek ini dilisensikan di bawah **MIT License**. Lihat file `LICENSE.md` untuk detail lebih lanjut.

## 11. Kontak
Jika Anda memiliki pertanyaan atau ingin berkontribusi, silakan hubungi:
- **Nama Pengembang**: [Nama Anda]
- **Email**: [email@gmail.com]

---

