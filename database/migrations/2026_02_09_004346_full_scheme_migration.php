<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Users
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'pengguna_asn', 'kabid', 'operator']);
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('no_wa')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        // 2. Role Specializations
        Schema::create('super_admin', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->onDelete('cascade');
            $table->string('nip')->nullable();
            $table->timestamps();
        });

        Schema::create('pengguna_asn', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->onDelete('cascade');
            $table->string('nip');
            $table->timestamps();
        });

        Schema::create('kabid', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->onDelete('cascade');
            $table->string('nip');
            $table->timestamps();
        });

        Schema::create('operator', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->onDelete('cascade');
            $table->string('nip');
            $table->timestamps();
        });

        // 3. Master Layanan
        Schema::create('layanan', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->boolean('status_arsip')->default(false);
            $table->enum('status_prioritas', ['rendah', 'sedang', 'tinggi']);
            $table->timestamps();
        });

        // 4. Tiket
        Schema::create('tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid');
            $table->foreignUuid('layanan_id')->constrained('layanan', 'uuid');
            $table->foreignUuid('petugas_id')->nullable()->constrained('users', 'uuid');
            $table->string('no_tiket')->unique();
            $table->text('deskripsi');
            $table->enum('status', ['diajukan', 'ditangani', 'selesai', 'ditolak']);
            $table->timestamps();
        });

        // 5. Log & Komentar
        Schema::create('riwayat_status_tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            $table->foreignUuid('users_id')->constrained('users', 'uuid');
            $table->enum('status', ['diajukan', 'ditangani', 'selesai', 'ditolak']);
            $table->timestamps();
        });

        Schema::create('komentar_tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            $table->foreignUuid('users_id')->constrained('users', 'uuid');
            $table->string('komentar');
            $table->timestamps();
        });

        // 6. Detail Layanan (Nama kolom disingkat agar < 63 Karakter)
        
        Schema::create('detail_tiket_layanan_pengaduan_elektronik', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            $table->text('detail_pengaduan');
            $table->string('lampiran_screenshot')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_tiket_layanan_email_gov', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            
            // PD = Perangkat Daerah
            $table->string('pd_no_surat');
            $table->timestamp('pd_tgl');
            $table->integer('pd_hal');
            $table->string('pd_instansi_nama');
            $table->string('pd_bidang');
            $table->string('pd_alamat');
            $table->string('pd_telp');
            $table->string('pd_email');
            $table->string('pd_pj_nama');
            $table->string('pd_pj_nip');
            $table->string('pd_pj_jabatan');
            $table->string('pd_pj_email');
            $table->string('pd_pj_kontak');
            $table->enum('pd_jenis_layanan', ['permohonan baru', 'reset password', 'hapus akun', 'ganti nama akun']);
            $table->text('pd_alasan_hapus_ganti')->nullable();
            $table->string('pd_usulan_email')->nullable();

            // ASN Section
            $table->string('asn_no_surat');
            $table->timestamp('asn_tgl');
            $table->integer('asn_hal');
            $table->string('asn_nama');
            $table->string('asn_nip');
            $table->string('asn_jabatan');
            $table->string('asn_instansi');
            $table->string('asn_kontak');
            $table->enum('asn_jenis_layanan', ['permohonan baru', 'reset password', 'hapus akun', 'ganti nama akun']);
            $table->timestamps();
        });

        Schema::create('detail_tiket_layanan_subdomain', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            $table->string('no_surat');
            $table->timestamp('tanggal');
            $table->integer('halaman');
            $table->string('instansi_opd');
            $table->string('instansi_bidang');
            $table->string('instansi_alamat');
            $table->string('instansi_telp');
            $table->string('instansi_email');
            $table->string('pj_admin_nama');
            $table->string('pj_admin_nip');
            $table->string('pj_admin_jabatan');
            $table->string('pj_admin_email');
            $table->string('pj_admin_telp');
            $table->string('pj_teknis_nama');
            $table->string('pj_teknis_instansi');
            $table->string('pj_teknis_jabatan');
            $table->string('pj_teknis_email');
            $table->string('pj_teknis_telp');
            $table->string('subdomain_nama');
            $table->string('subdomain_ip');
            $table->string('subdomain_redirect')->nullable();
            $table->text('subdomain_deskripsi');
            $table->enum('subdomain_jenis', ['permohonan baru', 'ganti nama sub domain', 'penghapusan sub domain']);
            $table->timestamps();
        });

        Schema::create('detail_tiket_layanan_pembuatan_apps', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            
            // Pengajuan (Awal)
            $table->string('ajuan_no_surat');
            $table->timestamp('ajuan_tgl');
            $table->string('ajuan_nama_sistem');
            $table->text('ajuan_ket_sistem');
            $table->string('ajuan_ttd_nama');
            $table->string('ajuan_ttd_nip');
            $table->string('ajuan_perintah_pj1_nama');
            $table->string('ajuan_perintah_pj1_nip');
            $table->string('ajuan_perintah_pj1_jabatan');
            $table->string('ajuan_perintah_pj2_nama');
            $table->string('ajuan_perintah_pj2_nip');
            $table->string('ajuan_perintah_pj2_jabatan');
            $table->string('ajuan_fitur');
            $table->text('ajuan_ket_fitur');

            // Pengembangan
            $table->string('kembang_no_surat');
            $table->timestamp('kembang_tgl');
            $table->string('kembang_ttd_nama');
            $table->string('kembang_ttd_nip');
            $table->string('kembang_nama_sistem');
            $table->string('kembang_fitur');
            $table->text('kembang_ket');
            $table->string('kembang_perintah_pj1_nama');
            $table->string('kembang_perintah_pj1_nip');
            $table->string('kembang_perintah_pj1_jabatan');
            $table->string('kembang_perintah_pj2_nama');
            $table->string('kembang_perintah_pj2_nip');
            $table->string('kembang_nama_fitur');
            $table->text('kembang_ket_fitur');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_tiket_layanan_pembuatan_apps');
        Schema::dropIfExists('detail_tiket_layanan_subdomain');
        Schema::dropIfExists('detail_tiket_layanan_email_gov');
        Schema::dropIfExists('detail_tiket_layanan_pengaduan_elektronik');
        Schema::dropIfExists('komentar_tiket');
        Schema::dropIfExists('riwayat_status_tiket');
        Schema::dropIfExists('tiket');
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('operator');
        Schema::dropIfExists('kabid');
        Schema::dropIfExists('pengguna_asn');
        Schema::dropIfExists('super_admin');
        Schema::dropIfExists('users');
    }
};