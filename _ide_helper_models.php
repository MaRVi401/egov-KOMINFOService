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
 * @property-read \App\Models\Tiket|null $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananEmailGov query()
 */
	class DetailTiketLayananEmailGov extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Tiket|null $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApps newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApps newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPembuatanApps query()
 */
	class DetailTiketLayananPembuatanApps extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Tiket|null $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananPengaduanElektronik query()
 */
	class DetailTiketLayananPengaduanElektronik extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Tiket|null $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTiketLayananSubdomain query()
 */
	class DetailTiketLayananSubdomain extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid query()
 */
	class Kabid extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket query()
 */
	class KomentarTiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tikets
 * @property-read int|null $tikets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan query()
 */
	class Layanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator query()
 */
	class Operator extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaAsn query()
 */
	class PenggunaAsn extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket query()
 */
	class RiwayatStatusTiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin query()
 */
	class SuperAdmin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\DetailTiketLayananPembuatanApps|null $detailApps
 * @property-read \App\Models\DetailTiketLayananEmailGov|null $detailEmailGov
 * @property-read \App\Models\DetailTiketLayananPengaduanElektronik|null $detailPengaduan
 * @property-read \App\Models\DetailTiketLayananSubdomain|null $detailSubdomain
 * @property-read \App\Models\Layanan|null $layanan
 * @property-read \App\Models\User|null $petugas
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket query()
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
 * @property string|null $email
 * @property string|null $no_wa
 * @property string|null $avatar
 * @property string|null $remember_token
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 */
	class User extends \Eloquent {}
}

