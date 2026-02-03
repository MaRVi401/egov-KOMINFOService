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
| Framework      | Laravel 11                      |
| Database       | PostgreSQL (Docker Container)   |
| Object Storage | MinIO S3 (Docker Container)     |
| Environment    | Docker Desktop & Docker Compose |
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

## 🧪 Pengujian Sistem

Untuk memastikan integrasi **Laravel + PostgreSQL + MinIO** berjalan dengan baik, gunakan Laravel Tinker.

### Masuk ke Tinker

```bash
php artisan tinker
```

### Test Koneksi Database

```php
App\\Models\\User::count();
```

### Test Object Storage (MinIO)

```php
use Illuminate\\Support\\Facades\\Storage;

Storage::disk('s3')->put('test.txt', 'Koneksi Berhasil');
Storage::disk('s3')->exists('test.txt');
```

Jika hasilnya `true`, maka koneksi MinIO berhasil.

---

## 🌐 Akses Layanan

| Service         | URL                                            | Keterangan                           |
| --------------- | ---------------------------------------------- | ------------------------------------ |
| Web Application | [http://localhost:8000](http://localhost:8000) | Aplikasi utama                       |
| MinIO Console   | [http://localhost:9001](http://localhost:9001) | User: `admin`<br>Pass: `password123` |
| PostgreSQL      | Port 5432                                      | Database Service                     |

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
Mahasiswa Rekayasa Perangkat Lunak – Semester 6

---

## 📌 Status Proyek

🚧 **In Development**
Proyek pengembangan sistem E-Government sebagai bagian dari kebutuhan akademik dan implementasi teknologi pemerintahan digital.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan akademik dan pengembangan internal. Lisensi akan ditentukan pada tahap selanjutnya.
