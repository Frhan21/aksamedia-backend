<h1 align="center">Aksa Media Backend</h1>

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
    Backend service untuk aplikasi <strong>Aksa Media</strong>, dibangun menggunakan Laravel.
</p>

<p align="center">
    <a href="#"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
    <a href="#"><img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel Version"></a>
    <a href="#"><img src="https://img.shields.io/badge/PHP-^8.1-blue.svg" alt="PHP Version"></a>
</p>

---

## 📑 Table of Contents
- [Tentang Proyek](#tentang-proyek)
- [Teknologi & Komponen Utama](#teknologi--komponen-utama)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Penggunaan](#penggunaan)
- [Pengujian](#pengujian)
- [Dokumentasi API](#dokumentasi-api)
- [Kontribusi](#kontribusi)
- [Kontak](#kontak)
- [Lisensi](#lisensi)

## 📌 Tentang Proyek
**Aksa Media Backend** adalah layanan backend untuk aplikasi Aksa Media. Proyek ini berfungsi sebagai API server yang menangani autentikasi, manajemen data, dan layanan terkait aplikasi, dengan dukungan lokalitas untuk Indonesia dan Malaysia.

## 🛠️ Teknologi & Komponen Utama
- **Framework:** [Laravel](https://laravel.com/)
- **Bahasa:** PHP
- **Database:** MySQL / PostgreSQL
- **Dependency Management:** Composer
- **Tanggal & Waktu:** [Carbon](https://carbon.nesbot.com/)
- **Data Seeding:** [FakerPHP](https://fakerphp.github.io/)
- **Pengujian:** PHPUnit

## ✅ Prasyarat
- PHP ^8.1
- Composer
- Database Server (MySQL / MariaDB / PostgreSQL)
- Node.js & NPM (opsional untuk frontend assets)

## 🚀 Instalasi
1. Clone repository:
    ```bash
    git clone <URL_REPOSITORY_ANDA>
    cd aksamedia-backend
    ```

2. Install dependensi:
    ```bash
    composer install
    ```

3. Salin `.env`:
    ```bash
    cp .env.example .env
    ```

4. Generate kunci aplikasi:
    ```bash
    php artisan key:generate
    ```

5. Konfigurasi database di file `.env`:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=aksamedia
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Jalankan migrasi:
    ```bash
    php artisan migrate
    ```

7. (Opsional) Seeder:
    ```bash
    php artisan db:seed
    ```

8. Jalankan server:
    ```bash
    php artisan serve
    ```

## 🧩 Penggunaan
Aplikasi berjalan di:
