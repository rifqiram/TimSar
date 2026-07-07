# AGENTS.md

## Tujuan

Project ini mengadopsi teknikal SIREKPEL tanpa rombak total. Struktur lama (`mentor`, `peserta`, `pelatihan`, `pendaftaran`) tetap digunakan, lalu ditambah entitas teknikal rekomendasi:

- `kategori`
- `keahlian`
- `pelatihan_keahlian`
- `peserta_keahlian`
- endpoint rekomendasi

## Prinsip Implementasi

- API-only changes berada di `routes/api.php` dan controller terkait.
- Response API wajib memakai envelope:

```json
{
  "success": true,
  "message": "...",
  "data": {}
}
```

- Error response:

```json
{
  "success": false,
  "message": "...",
  "errors": {}
}
```

- Gunakan helper di `app/Http/Controllers/Controller.php`:
  - `successResponse()`
  - `errorResponse()`
  - `authorizeAdmin()`

## Autentikasi (Dual Auth Mode)

API menggunakan custom middleware `auth.sirekpel` yang mendukung dua metode login:
1. **Laravel Sanctum** (token dinamis, format `1|xyz...`). Ideal untuk frontend web.
2. **API Token / API Key Statis** (membaca kolom `api_token` di table `tabel_users`). Ideal untuk pengujian langsung di Postman atau integrasi luar. Token ini bisa dikirim via:
   - Header `Authorization: Bearer <token>`
   - Header `X-API-Key: <token>`
   - Query parameter `?api_token=<token>`

### Akun Demo Default (Seeded)
- **Role Admin**:
  - Email: `admin@example.com`
  - Password: `password`
  - Static API Key: `admintoken` (bisa langsung digunakan di Postman!)

## Role

- `admin`: kelola master data dan delete/update data penting.
- `user`: dipakai sebagai pencari kerja/peserta secara kompatibel dengan struktur lama.

## Entity SIREKPEL Tambahan

Tabel tambahan:

- `tabel_kategori`
- `tabel_keahlian`
- `tabel_pelatihan_keahlian`
- `tabel_peserta_keahlian`

Model tambahan:

- `App\Models\Kategori`
- `App\Models\Keahlian`

Controller tambahan:

- `KategoriController`
- `KeahlianController`
- `ProfilKeahlianController`
- `RekomendasiController`

## Endpoint Penting

```txt
POST   /api/login
POST   /api/register
GET    /api/me
POST   /api/logout
GET    /api/kategori
POST   /api/kategori
GET    /api/keahlian
POST   /api/keahlian
GET    /api/pelatihan
POST   /api/pelatihan
GET    /api/peserta/{peserta}/keahlian
PUT    /api/peserta/{peserta}/keahlian
GET    /api/rekomendasi?peserta_id=1
POST   /api/pelatihan/{pelatihan}/pendaftaran
GET    /api/peserta/{peserta}/riwayat
```

## Rekomendasi Logic

`RekomendasiController@index`:

- input: `peserta_id`
- ambil keahlian peserta
- ambil pelatihan aktif
- exclude pelatihan yang sudah didaftari peserta
- hitung `matched_skills`, `missing_skills`, `match_count`, `gap_count`, `score`
- sort by `score` descending

## File Artefak

- Postman Collection: `SIREKPEL_Collection.json` dan `public/docs/My Collection.postman_collection.json` (keduanya identik dan memiliki default token `admintoken`)
- Dokumentasi markdown: `SIREKPEL_Dokumentasi_Baru.md`
- Plan awal: `C:\Users\user\.claude\plans\atomic-orbiting-rain.md`

## Verifikasi Wajib Setelah Perubahan

```bash
php artisan route:list --path=api
php artisan migrate
php artisan test
```

Status implementasi terakhir:
- Seluruh 10 test suite (40 assertions) passed dengan sukses!



## Audit & Refactoring Log (Tahap 1-10)

Sistem telah diaudit dan direfaktor pada 07 Juli 2026 dengan hasil sebagai berikut:
- **Git Flow:** Membersihkan 13 *Merge Conflicts* fatal pada `web.php`, `AuthController.php`, dan `navbar.blade.php`.
- **Database:** Normalisasi struktur dengan menghapus kolom reduksi (`kategori`, `status` pada pelatihan, dan `keahlian` string pada peserta) serta menginjeksikan Index pencarian (Query Optimization).
- **Backend Architecture:** Penerapan **SOLID** dan **DRY**. Memusatkan validasi manual menjadi puluhan kelas **FormRequest**, menerapkan Paginasi massal terpadu melalui *macro* `paginatedResponse()` di `BaseController`.
- **Security:** Menutup celah bypass autentikasi (`User::first()`), menambal perlindungan rute via `authorizeAdmin()`, dan membangkitkan perlindungan massal limitasi lalu-lintas **Rate Limiting** via Middleware Laravel 11.
- **Performance:** Mematikan fitur **Lazy Loading (N+1 Query)** dari Eloquent di taraf Global (Non-Production), mengubah kueri berat menggunakan *Eager Loading* `->with()`, serta menanamkan sistem **Caching (Redis/File)** di kalkulator `RekomendasiController`.
- **Frontend UI/UX:** Restrukturisasi tema terang dan gelap (**Dark Mode**) menggunakan konfigurasi *Tailwind CDN* pada `user.blade.php`. Memperbaiki aksesibilitas *(Aria-Hidden, Roles)* dan komponen *View* kotor (Dead Code Removal). Seluruh tes *Test-Suite* PHPUnit tereksekusi dengan kembalian 100% Passed.

## Frontend Layout (Role User)

- Menggunakan sistem UI Layout terpisah: `layouts/user.blade.php`.
- Autentikasi Frontend berbasis localStorage (`getApiToken()`, `getApiUser()`) melalui API.
- Proteksi route berbasis Client-Side JS (bukan middleware `auth.sirekpel` secara server-side). Akses view akan otomatis di-*redirect* jika token localStorage kosong.
- Komponen Sidebar bersih dari legacy CSS `sidebar-expanded` dan animasi collapse yang tidak digunakan. Sidebar konstan, responsif, & kontras tinggi.
- UI Dashboard menggunakan `bg-slate-50`, container shadow modern (`rounded-xl`), dan card `bg-gradient` layaknya template Tabler/Flowbite modern.