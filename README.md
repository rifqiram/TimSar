# 🚀 TimSar - Sistem Rekomendasi Pelatihan Berbasis Laravel

<p align="center">
  <img src="public/images/logo.png" alt="TimSar Logo" width="180">
</p>

<p align="center">
Sistem informasi manajemen pelatihan berbasis web yang dilengkapi dengan fitur <strong>Rekomendasi Pelatihan</strong> berdasarkan profil dan keahlian peserta menggunakan Laravel REST API.
</p>

---

# 📖 Tentang Proyek

**TimSar** merupakan aplikasi berbasis web yang dikembangkan untuk membantu proses pengelolaan pelatihan secara digital. Sistem menyediakan dua jenis pengguna, yaitu **Administrator** dan **Peserta**, dengan fitur pengelolaan data pelatihan, mentor, kategori, keahlian, pendaftaran, serta rekomendasi pelatihan yang sesuai dengan profil peserta.

Selain menyediakan antarmuka berbasis Blade, sistem juga menyediakan **REST API** sehingga dapat diintegrasikan dengan aplikasi mobile maupun layanan pihak ketiga.

---

# ✨ Fitur Utama

## 👤 Autentikasi

* Login
* Register
* Logout
* Profile Management
* Token Authentication (Laravel Sanctum)

---

## 👨‍💼 Admin

* Dashboard
* CRUD Pelatihan
* CRUD Mentor
* CRUD Kategori
* CRUD Keahlian
* CRUD Peserta
* Manajemen Pendaftaran
* Monitoring Aktivitas

---

## 👨‍🎓 Peserta

* Melengkapi Profil
* Melihat Daftar Pelatihan
* Mendaftar Pelatihan
* Riwayat Pelatihan
* Melihat Rekomendasi Pelatihan

---

## 🎯 Sistem Rekomendasi

Fitur rekomendasi merupakan nilai utama dari aplikasi ini.

Sistem akan:

* membaca profil peserta
* mencocokkan keahlian peserta
* mencari pelatihan yang sesuai
* mengecualikan pelatihan yang sudah pernah diikuti
* menghitung skor kecocokan
* menampilkan:

  * Score
  * Matched Skills
  * Missing Skills
  * Gap Count

---

# 🛠️ Teknologi yang Digunakan

## Backend

* PHP 8.x
* Laravel 13
* Laravel Sanctum
* Eloquent ORM
* REST API
* Resource API
* Form Request Validation
* Custom Middleware
* Laravel Cache

## Frontend

* Blade Template
* HTML5
* CSS3
* JavaScript
* Tailwind CSS
* Vite

## Database

* MySQL
* Migration
* Seeder
* Factory

## Testing

* PHPUnit
* Faker

---

# 🏗️ Arsitektur Sistem

Project menggunakan pola **MVC (Model View Controller)** yang disediakan Laravel.

```
app/
 ├── Http/
 │    ├── Controllers
 │    ├── Middleware
 │    └── Requests
 │
 ├── Models
 ├── Services
 ├── Providers
 └── Helpers

database/
 ├── migrations
 ├── seeders
 └── factories

resources/
 ├── views
 ├── css
 └── js

routes/
 ├── web.php
 └── api.php
```

---

# 📦 Instalasi

## Clone Repository

```bash
git clone https://github.com/rifqiram/TimSar.git
```

Masuk ke folder project

```bash
cd TimSar
```

---

## Install Dependency

```bash
composer install
```

Install frontend

```bash
npm install
```

---

## Konfigurasi Environment

Salin file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Konfigurasikan database pada file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=timsar
DB_USERNAME=root
DB_PASSWORD=
```

---

## Migrasi Database

```bash
php artisan migrate --seed
```

---

## Build Asset

Development

```bash
npm run dev
```

Production

```bash
npm run build
```

---

## Jalankan Server

```bash
php artisan serve
```

Akses aplikasi

```
http://127.0.0.1:8000
```

---

# 🔌 REST API

Project menyediakan sekitar **40 endpoint REST API**.

Beberapa endpoint utama:

| Method | Endpoint         | Keterangan        |
| ------ | ---------------- | ----------------- |
| POST   | /api/login       | Login             |
| POST   | /api/register    | Register          |
| POST   | /api/logout      | Logout            |
| GET    | /api/profile     | Profil User       |
| GET    | /api/pelatihan   | Daftar Pelatihan  |
| POST   | /api/pendaftaran | Daftar Pelatihan  |
| GET    | /api/rekomendasi | Hasil Rekomendasi |

Seluruh endpoint menggunakan format response JSON yang konsisten.

---

# 🔐 Keamanan

Project telah menerapkan:

* Laravel Sanctum
* API Token Authentication
* Form Request Validation
* Middleware Authentication
* Authorization berdasarkan Role
* CSRF Protection
* Mass Assignment Protection

---

# 🧪 Testing

Menjalankan seluruh testing

```bash
php artisan test
```

Atau

```bash
php artisan test --filter NamaTest
```

Hasil pengujian terakhir:

* ✅ 10 Test Suite
* ✅ 40 Assertions
* ✅ Seluruh test berhasil dijalankan

---

# 📚 Dokumentasi

Project telah menyediakan:

* Dokumentasi Sistem
* Dokumentasi REST API
* Postman Collection

Seluruh file dokumentasi dapat ditemukan pada folder:

```
public/docs/
```

---

# 📈 Kelebihan Sistem

* REST API yang terstruktur
* Laravel Sanctum Authentication
* Dashboard Admin & User
* Sistem Rekomendasi Pelatihan
* Response API Konsisten
* Database Migration & Seeder
* Automated Testing
* Modern UI menggunakan Tailwind CSS
* Siap dikembangkan menjadi aplikasi mobile

---

# ⚠️ Catatan Pengembangan

Beberapa peningkatan yang direkomendasikan:

* Server-side Authorization yang lebih ketat
* API Versioning
* Activity Logging
* Monitoring dan Observability
* Pengujian lebih luas pada modul rekomendasi
* Optimasi cache agar hasil rekomendasi lebih real-time

---

# 👨‍💻 Developer

**Rifqi Ramadhan 2305101030**
**David 23051010--**
**Syahrul Haris Wijaya 2305101021**
**Levy Danendra 23051010--**
**Rizky Cahya 23051010--**

Universitas PGRI Madiun

Program Studi Teknik Informatika

---

# 📄 License

Project ini menggunakan lisensi **MIT License**.
