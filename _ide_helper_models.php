<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $pd_no_surat
 * @property string $pd_tgl
 * @property int|null $pd_hal
 * @property string|null $pd_instansi_nama
 * @property string|null $pd_nama_kepala_instansi
 * @property string|null $pd_bidang
 * @property string|null $pd_alamat
 * @property string|null $pd_telp
 * @property string|null $pd_email
 * @property string|null $pd_pj_nama
 * @property string|null $pd_pj_nip
 * @property string|null $pd_pj_jabatan
 * @property string|null $pd_pj_email
 * @property string|null $pd_pj_kontak
 * @property string|null $pd_jenis_layanan
 * @property string|null $pd_alasan_hapus_akun
 * @property string|null $pd_alasan_ganti_nama
 * @property string|null $pd_usulan_email
 * @property string $asn_no_surat
 * @property string $asn_tgl
 * @property int|null $asn_hal
 * @property string|null $asn_nama_lengkap
 * @property string|null $asn_nip
 * @property string|null $asn_jabatan
 * @property string|null $asn_instansi
 * @property string|null $asn_kontak
 * @property string|null $asn_jenis_layanan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnHal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnInstansi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnJenisLayanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnKontak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereAsnTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdAlasanGantiNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdAlasanHapusAkun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdHal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdInstansiNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdJenisLayanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdNamaKepalaInstansi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdPjEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdPjJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdPjKontak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdPjNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdPjNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov wherePdUsulanEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov whereUuid($value)
 */
	class DetailTiketLayananEmailGov extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string|null $ajuan_no_surat
 * @property \Illuminate\Support\Carbon|null $ajuan_tgl
 * @property string|null $ajuan_nama_sistem
 * @property string|null $ajuan_ket_sistem
 * @property string|null $ajuan_ttd_nama
 * @property string|null $ajuan_ttd_nip
 * @property string|null $ajuan_perintah_pj1_nama
 * @property string|null $ajuan_perintah_pj1_nip
 * @property string|null $ajuan_perintah_pj1_jabatan
 * @property string|null $ajuan_perintah_pj2_nama
 * @property string|null $ajuan_perintah_pj2_nip
 * @property string|null $ajuan_perintah_pj2_jabatan
 * @property string|null $ajuan_nama_skpd
 * @property array<array-key, mixed>|null $ajuan_fitur
 * @property string|null $ajuan_ket_fitur
 * @property string|null $kembang_no_surat
 * @property \Illuminate\Support\Carbon|null $kembang_tgl
 * @property string|null $kembang_ttd_nama
 * @property string|null $kembang_ttd_nip
 * @property string|null $kembang_nama_sistem
 * @property string|null $kembang_ket
 * @property string|null $kembang_perintah_pj1_nama
 * @property string|null $kembang_perintah_pj1_nip
 * @property string|null $kembang_perintah_pj1_jabatan
 * @property string|null $kembang_perintah_pj2_nama
 * @property string|null $kembang_perintah_pj2_jabatan
 * @property string|null $kembang_perintah_pj2_nip
 * @property string|null $kembang_nama_skpd
 * @property array<array-key, mixed>|null $kembang_nama_fitur
 * @property string|null $kembang_ket_fitur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanFitur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanKetFitur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanKetSistem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanNamaSistem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanNamaSkpd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanPerintahPj1Jabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanPerintahPj1Nama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanPerintahPj1Nip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanPerintahPj2Jabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanPerintahPj2Nama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanPerintahPj2Nip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanTtdNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereAjuanTtdNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangKet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangKetFitur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangNamaFitur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangNamaSistem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangNamaSkpd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangPerintahPj1Jabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangPerintahPj1Nama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangPerintahPj1Nip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangPerintahPj2Jabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangPerintahPj2Nama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangPerintahPj2Nip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangTtdNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereKembangTtdNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApp whereUuid($value)
 */
	class DetailTiketLayananPembuatanApp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $detail_pengaduan
 * @property string|null $lampiran_screenshot
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik whereDetailPengaduan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik whereLampiranScreenshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik whereUuid($value)
 */
	class DetailTiketLayananPengaduanElektronik extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $no_surat
 * @property string $tanggal
 * @property int $halaman
 * @property string $instansi_opd
 * @property string $instansi_bidang
 * @property string $instansi_nama_kepala
 * @property string $instansi_alamat
 * @property string $instansi_telp
 * @property string $instansi_email
 * @property string $pj_admin_nama
 * @property string $pj_admin_nip
 * @property string $pj_admin_jabatan
 * @property string $pj_admin_email
 * @property string $pj_admin_telp
 * @property string $pj_teknis_nama
 * @property string $pj_teknis_instansi
 * @property string $pj_teknis_alamat
 * @property string $pj_teknis_email
 * @property string $pj_teknis_telp
 * @property string $subdomain_nama
 * @property string $subdomain_alamat
 * @property string $subdomain_ip
 * @property string|null $subdomain_redirect
 * @property string $subdomain_deskripsi
 * @property string $subdomain_jenis
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereHalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereInstansiAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereInstansiBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereInstansiEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereInstansiNamaKepala($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereInstansiOpd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereInstansiTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjAdminEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjAdminJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjAdminNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjAdminNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjAdminTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjTeknisAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjTeknisEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjTeknisInstansi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjTeknisNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain wherePjTeknisTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereSubdomainAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereSubdomainDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereSubdomainIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereSubdomainJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereSubdomainNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereSubdomainRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain whereUuid($value)
 */
	class DetailTiketLayananSubdomain extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereUuid($value)
 */
	class Kabid extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $users_id
 * @property string $komentar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereKomentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereUuid($value)
 */
	class KomentarTiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $nama
 * @property bool $status_arsip
 * @property string $status_prioritas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tikets
 * @property-read int|null $tikets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereStatusArsip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereStatusPrioritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUuid($value)
 */
	class Layanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUuid($value)
 */
	class Operator extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn whereUuid($value)
 */
	class PenggunaAsn extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $users_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereUuid($value)
 */
	class RiwayatStatusTiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string|null $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUuid($value)
 */
	class SuperAdmin extends \Eloquent {}
}

namespace App\Models{
/**
 * PHPDoc ini membantu Intelephense mengenali properti database secara otomatis
 *
 * @property string $uuid
 * @property string $users_id
 * @property string $layanan_id
 * @property string|null $petugas_id
 * @property string $no_tiket
 * @property string $deskripsi
 * @property string $status
 * @property string|null $lampiran
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * * @property-read \App\Models\User $user
 * @property-read \App\Models\Layanan $layanan
 * @property-read \App\Models\DetailTiketLayananPembuatanApp|null $detailApps
 * @property-read \App\Models\DetailTiketLayananEmailGov|null $detailEmailGov
 * @property-read \App\Models\DetailTiketLayananPengaduanElektronik|null $detailPengaduan
 * @property-read \App\Models\DetailTiketLayananSubdomain|null $detailSubdomain
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KomentarTiket> $komentar
 * @property-read int|null $komentar_count
 * @property-read \App\Models\User|null $petugas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RiwayatStatusTiket> $riwayatStatus
 * @property-read int|null $riwayat_status_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereLayananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereNoTiket($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket wherePetugasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereUuid($value)
 */
	class Tiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $nama
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string|null $alamat
 * @property string $email
 * @property string|null $no_wa
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kabid|null $kabid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Operator|null $operator
 * @property-read \App\Models\PenggunaAsn|null $penggunaAsn
 * @property-read \App\Models\SuperAdmin|null $superAdmin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tiketDibuat
 * @property-read int|null $tiket_dibuat_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tiketDitangani
 * @property-read int|null $tiket_ditangani_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNoWa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 */
	class User extends \Eloquent {}
}

