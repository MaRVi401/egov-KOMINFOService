<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Master Users
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'pengguna_asn', 'kabid', 'operator']);
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('no_wa');
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        // 2. Role Specializations (Relasi One-to-One)
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

        // 4. Tabel Utama Tiket
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

        // 5. Tabel Riwayat & Komentar Tiket
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

        // 6. DETAIL LAYANAN (SPESIFIK)

        // Detail: Pengaduan Sistem Elektronik
        Schema::create('detail_tiket_layanan_pengaduan_sistem_elektronik', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            $table->text('detail_pengaduan');
            $table->string('lampiran_screenshot')->nullable();
            $table->timestamps();
        });

        // Detail: Email Gov
        Schema::create('detail_tiket_layanan_email_gov', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            
            // Perangkat Daerah Section
            $table->integer('perangkat_daerah_no_surat');
            $table->timestamp('perangkat_daerah_tanggal');
            $table->integer('perangkat_daerah_halaman');
            $table->string('perangkat_daerah_data_instansi_pemohon_nama_perangkat_daerah');
            $table->string('perangkat_daerah_data_instansi_pemohon_bidang_bagian_uptd');
            $table->string('perangkat_daerah_data_instansi_pemohon_alamat');
            $table->integer('perangkat_daerah_data_instansi_pemohon_no_telepon');
            $table->string('perangkat_daerah_data_instansi_pemohon_email');
            $table->string('perangkat_daerah_data_penanggung_jawab_email_nama');
            $table->string('perangkat_daerah_data_penanggung_jawab_email_nip');
            $table->string('perangkat_daerah_data_penanggung_jawab_email_jabatan');
            $table->string('perangkat_daerah_data_penanggung_jawab_email_email');
            $table->string('perangkat_daerah_data_penanggung_jawab_email_no_hp_atau_no_wa');
            $table->enum('perangkat_daerah_data_akun_jenis_layanan', ['permohonan baru', 'reset password', 'hapus akun', 'ganti nama akun']);
            $table->string('perangkat_daerah_data_akun_hapus_akun_alasan')->nullable();
            $table->string('perangkat_daerah_data_akun_ganti_nama_alasan')->nullable();
            $table->text('perangkat_daerah_data_akun_usulan_nama_email')->nullable();

            // Dinas ASN Section
            $table->integer('dinas_asn_no_surat');
            $table->timestamp('dinas_asn_tanggal');
            $table->integer('dinas_asn_halaman');
            $table->string('dinas_asn_data_pemohon_nama_lengkap');
            $table->string('dinas_asn_data_pemohon_nip');
            $table->string('dinas_asn_data_pemohon_jabatan');
            $table->string('dinas_asn_data_pemohon_instansi');
            $table->string('dinas_asn_data_pemohon_no_hp_atau_no_wa');
            $table->enum('dinas_asn_data_pemohon_jenis_layanan', ['permohonan baru', 'reset password', 'hapus akun', 'ganti nama akun']);
            $table->timestamps();
        });

        // Detail: Subdomain
        Schema::create('detail_tiket_layanan_subdomain', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            $table->string('no_surat');
            $table->timestamp('tanggal');
            $table->integer('halaman');
            $table->string('data_instansi_pemohon_opd');
            $table->string('data_instansi_pemohon_bidang_bagian_uptd');
            $table->string('data_instansi_pemohon_alamat');
            $table->string('data_instansi_pemohon_no_telepon');
            $table->string('data_instansi_pemohon_email');
            $table->string('data_penanggung_jawab_administratif_nama');
            $table->string('data_penanggung_jawab_administratif_nip');
            $table->string('data_penanggung_jawab_administratif_jabatan');
            $table->string('data_penanggung_jawab_administratif_email');
            $table->string('data_penanggung_jawab_administratif_no_telepon');
            $table->string('data_penanggung_jawab_teknis_nama');
            $table->string('data_penanggung_jawab_teknis_instansi');
            $table->string('data_penanggung_jawab_teknis_jabatan');
            $table->string('data_penanggung_jawab_teknis_email');
            $table->string('data_penanggung_jawab_teknis_no_telepon');
            $table->string('data_sub_domain_nama_sub_domain');
            $table->string('data_sub_domain_alamat_ip');
            $table->string('data_sub_domain_redirect')->nullable();
            $table->text('data_sub_domain_deskripsi_singkat_aplikasi_website_si');
            $table->enum('data_sub_domain_jenis_layanan', ['permohonan baru', 'ganti nama sub domain', 'penghapusan sub domain']);
            $table->timestamps();
        });

        // Detail: Pembuatan Aplikasi (Pengajuan & Pengembangan)
        Schema::create('detail_tiket_layanan_pembuatan_apps', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->onDelete('cascade');
            
            // Bagian Pengajuan
            $table->string('pengajuan_pembuatan_awal_sistem_no_surat');
            $table->timestamp('pengajuan_pembuatan_awal_sistem_tanggal');
            $table->string('pengajuan_pembuatan_awal_sistem_nama_sistem');
            $table->text('pengajuan_pembuatan_awal_sistem_keterangan_sistem');
            $table->string('pengajuan_pembuatan_awal_sistem_ttd_dibawah_ini');
            $table->string('pengajuan_pembuatan_awal_sistem_nip_ttd_dibawah_ini');
            $table->string('pengajuan_pembuatan_awal_sistem_memerintahkan_kepada_pejabat_1_nama');
            $table->string('pengajuan_pembuatan_awal_sistem_memerintahkan_kepada_pejabat_1_nip');
            $table->string('pengajuan_pembuatan_awal_sistem_memerintahkan_kepada_pejabat_1_jabatan');
            $table->string('pengajuan_pembuatan_awal_sistem_memerintahkan_kepada_pejabat_2_nama');
            $table->string('pengajuan_pembuatan_awal_sistem_memerintahkan_kepada_pejabat_2_nip');
            $table->string('pengajuan_pembuatan_awal_sistem_memerintahkan_kepada_pejabat_2_jabatan');
            $table->string('pengajuan_pembuatan_awal_sistem_fitur');
            $table->text('pengajuan_pembuatan_awal_sistem_keterangan_fitur');

            // Bagian Pengembangan
            $table->string('pengembangan_fitur_aplikasi_no_surat');
            $table->timestamp('pengembangan_fitur_aplikasi_tanggal');
            $table->string('pengembangan_fitur_aplikasi_nama_ttd_di_bawah_ini');
            $table->string('pengembangan_fitur_aplikasi_nip_ttd_di_bawah_ini');
            $table->string('pengembangan_fitur_aplikasi_nama_sistem');
            $table->string('pengembangan_fitur_aplikasi_fitur');
            $table->text('pengembangan_fitur_aplikasi_keterangan');
            $table->string('pengembangan_fitur_aplikasi_memerintahkan_kepada_pejabat_1_nama');
            $table->string('pengembangan_fitur_aplikasi_memerintahkan_kepada_pejabat_1_nip');
            $table->string('pengembangan_fitur_aplikasi_memerintahkan_kepada_pejabat_1_jabatan');
            $table->string('pengembangan_fitur_aplikasi_memerintahkan_kepada_pejabat_2_nama');
            $table->string('pengembangan_fitur_aplikasi_memerintahkan_kepada_pejabat_2_nip');
            $table->string('pengembangan_fitur_aplikasi_nama_fitur');
            $table->text('pengembangan_fitur_aplikasi_keterangan_fitur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tiket_layanan_pembuatan_apps');
        Schema::dropIfExists('detail_tiket_layanan_subdomain');
        Schema::dropIfExists('detail_tiket_layanan_email_gov');
        Schema::dropIfExists('detail_tiket_layanan_pengaduan_sistem_elektronik');
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