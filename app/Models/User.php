<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    // 1. Tentukan nama Primary Key (karena bukan 'id')
    protected $primaryKey = 'uuid';

    // 2. Beritahu Laravel bahwa Primary Key bukan angka auto-increment (tapi string UUID)
    public $incrementing = false;

    // 3. Tentukan tipe data Primary Key
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'nama',
        'username',
        'password',
        'role',
        'alamat',
        'email',
        'no_wa',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Opsional: Otomatis buat UUID saat membuat User baru lewat Eloquent
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
