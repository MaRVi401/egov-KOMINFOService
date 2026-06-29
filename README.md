<h1 align="center">DISKOMINFO SERVICE</h1>

<p align="center">
  <img src="https://subang.go.id/public/frontend/img/logoweb.png" width="300" alt="kominfo-subang">
</p>

## 📌 Deskripsi Proyek

**Diskominfo Service** adalah aplikasi layanan pemerintahan berbasis web yang dirancang untuk meningkatkan efisiensi birokrasi, pengelolaan dokumen digital, serta integrasi layanan publik di lingkungan **Dinas Komunikasi dan Informatika (Diskominfo)**.

Aplikasi ini dikembangkan menggunakan arsitektur modern dengan pendekatan **containerization (Docker)**, sehingga mudah dideploy, scalable, dan siap diintegrasikan dengan sistem lain (mobile apps maupun frontend modern).

---

## 🚀 Fitur Utama (Roadmap)

* 📁 **Manajemen Dokumen Digital**
  Penyimpanan dokumen secara aman menggunakan Object Storage berbasis **MinIO (S3 Compatible)**.

* 🔗 **E-Government Integration**
  Integrasi data layanan pemerintahan menggunakan basis data **PostgreSQL**.

* 🔌 **RESTful API Ready**
  Arsitektur backend siap digunakan untuk integrasi dengan aplikasi mobile atau sistem eksternal.

* 🔐 **Secure Storage Access**
  Implementasi **Temporary URL** untuk mengakses dokumen bersifat rahasia.

---

## 🛠️ Tech Stack & Infrastruktur

| Komponen       | Teknologi                       |
| -------------- | ------------------------------- |
| Framework      | Laravel 12                      |
| Database       | PostgreSQL (Docker Container)   |
| Object Storage | MinIO S3 (Docker Container)     |
| Environment    | Docker Desktop & Docker Compose |
| Bundler        | Vite 6                           |
| API Style      | RESTful API                     |

---

## ⚙️ Instalasi & Konfigurasi

### 1️⃣ Persiapan Awal

Pastikan ekstensi PHP berikut telah aktif pada `php.ini`:

* `pdo_pgsql`
* `pgsql`

Selain itu, pastikan **Docker Desktop** sudah terinstal dan berjalan.

---

### 2️⃣ Clone Repositori

```bash
git clone https://github.com/MaRVi401/egov-KOMINFOService
cd egov-KOMINFOService
```

---

### 3️⃣ Instalasi Dependensi

```bash
composer install
```
```bash
npm install
```

---

### 4️⃣ Konfigurasi Environment

Salin file `.env.example` menjadi `.env`, kemudian sesuaikan konfigurasi berikut:

```env
# Database Configuration
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=egovkominfo
DB_USERNAME=admin
DB_PASSWORD=password123

# Object Storage (MinIO) Configuration
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=admin
AWS_SECRET_ACCESS_KEY=password123
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=diskominfo-assets
AWS_ENDPOINT=http://127.0.0.1:9000
AWS_USE_PATH_STYLE_ENDPOINT=true
```

---

### 5️⃣ Menjalankan Infrastruktur Docker

Jalankan seluruh service (PostgreSQL & MinIO) menggunakan Docker Compose:

```bash
docker-compose up -d
```

Pastikan container berjalan dengan baik sebelum melanjutkan.

---

### 6️⃣ Setup Aplikasi Laravel

```bash
php artisan key:generate
php artisan migrate
```



---

### 7️⃣ Setup minIO 

1. Buka browser: [http://localhost:9001](http://localhost:9001)
2. Login: (Menggunakan username dan password yang ada di env)
3. Klik menu **Buckets** di sebelah kiri.
4. Klik tombol **Create Bucket**.
5. Isi nama bucket persis seperti di env.
6. Klik **Create Bucket**.

---

## 🧪 Pengujian Sistem

## 1. Konfigurasi Bucket via Terminal Docker

Ikuti urutan perintah berikut langsung dari terminal server/lokal Anda untuk masuk ke dalam container, membuat bucket, dan mengubah kebijakan aksesnya menjadi publik (`public` / full CRUD).

### Langkah Awal: Masuk ke Shell Container
```bash
docker exec -it minio-egov sh

```

### Langkah 2: Registrasi Alias Server Lokal

Daftarkan server MinIO lokal ke dalam sistem `mc` menggunakan kredensial root admin yang sesuai dengan `docker-compose.yml`:

```bash
mc alias set lokal http://localhost:9000 admin password123

```

### Langkah 3: Bersihkan Bucket yang Salah Nama (Opsional)

Jika Anda terlanjur membuat bucket dengan nama yang salah (misal: `minio-egov`), hapus secara paksa beserta isinya menggunakan perintah berikut:

```bash
mc rb lokal/minio-egov --force

```

### Langkah 4: Buat Bucket Baru yang Benar

Buat bucket baru khusus untuk menampung aset aplikasi dengan nama `diskominfo-assets`:

```bash
mc mb lokal/diskominfo-assets

```

### Langkah 5: Set Kebijakan Akses ke Public (Full CRUD)

Ubah *anonymous access policy* pada bucket tersebut agar aplikasi internal maupun luar dapat melakukan operasi *Create, Read, Update,* dan *Delete* secara lancar:

```bash
mc anonymous set public lokal/diskominfo-assets

```

### Langkah Akhir: Keluar dari Container

Pastikan konfigurasi berhasil, lalu keluar dari shell Docker:

```bash
exit

```

---

## 2. Integrasi & Sinkronisasi Environment Laravel

Sesuaikan konfigurasi environment (`.env`) dan filesystem di dalam project `diskominfo-service` Anda agar mengarah ke disk AWS S3 driver (MinIO).

### Konfigurasi `.env`

Tambahkan atau ubah baris pengaturan MinIO berikut pada file `.env` Anda:

```env
# MinIO Settings (E-Gov Kominfo Service)
AWS_ACCESS_KEY_ID=admin
AWS_SECRET_ACCESS_KEY=password123
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=diskominfo-assets
AWS_ENDPOINT=http://127.0.0.1:9000
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_URL=http://127.0.0.1:9000/diskominfo-assets

```

### Konfigurasi `config/filesystems.php`

Pastikan pada bagian array `disks` -> `s3`, parameter `use_path_style_endpoint` telah mengevaluasi tipe data string `.env` menjadi *boolean* murni menggunakan fungsi `filter_var`:

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => filter_var(env('AWS_USE_PATH_STYLE_ENDPOINT', true), FILTER_VALIDATE_BOOLEAN),
    'throw' => false,
    'report' => false,
],

```

---

## 3. Uji Coba CRUD via Laravel Tinker

Sebelum mengimplementasikannya ke dalam *controller* program, lakukan pembersihan *cache configuration* terlebih dahulu, kemudian jalankan pengetesan fungsionalitas CRUD lewat Laravel Tinker.

### Jalankan Pembersihan Cache Config

```bash
php artisan config:clear

```

### Buka Laravel Tinker

```bash
php artisan tinker

```

### Eksekusi Perintah Pengujian (Ketik baris demi baris):

```php
// 1. CREATE (Mengunggah file teks baru ke bucket)
Storage::disk('s3')->put('test-egov.txt', 'Halo Diskominfo, tes koneksi MinIO berhasil!');
// Output diharapkan: true

// 2. READ (Membaca isi file teks yang baru dibuat)
Storage::disk('s3')->get('test-egov.txt');
// Output diharapkan: "Halo Diskominfo, tes koneksi MinIO berhasil!"

// 3. UPDATE (Memperbarui / menimpa isi file lama)
Storage::disk('s3')->put('test-egov.txt', 'Data e-Gov berhasil diperbarui!');
// Output diharapkan: true

// 4. DELETE (Menghapus file dari bucket)
Storage::disk('s3')->delete('test-egov.txt');
// Output diharapkan: true

```

---

## 🌐 Akses Layanan

| Service         | URL                                            | Keterangan                           |
| --------------- | ---------------------------------------------- | ------------------------------------ |
| Web Application | [http://localhost:8000](http://localhost:8000) | Aplikasi utama                       |
| MinIO Console   | [http://localhost:9001](http://localhost:9001) | User: `admin`<br>Pass: `password123` |
| PostgreSQL      | Port 5432                                      | Database Service                     |

---
## 🖥️ Menjalankan Aplikasi

Aplikasi ini membutuhkan **dua proses yang berjalan secara bersamaan**.

### ▶️ Terminal 1 — Backend
Jalankan server Laravel:
```bash
php artisan serve
```
### ▶️ Terminal 2 — Frontend
Jalankan Vite untuk frontend:
```bash
npm run dev
```


---
## 📊 Arsitektur Singkat

```
User
 │
 ▼
Laravel Application
 │
 ├── PostgreSQL (Database)
 │
 └── MinIO (Object Storage)
```

---

## 👨‍💻 Developer

**Yss | Awil | Hasan**  
Mahasiswa **Rekayasa Perangkat Lunak (RPL)** – PMI 2026 

---

## 📌 Status Proyek

🚧 **In Development**
Proyek pengembangan sistem E-Government sebagai bagian dari kebutuhan akademik dan implementasi teknologi pemerintahan digital.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan akademik dan pengembangan internal. Lisensi akan ditentukan pada tahap selanjutnya.
