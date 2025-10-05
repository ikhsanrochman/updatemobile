<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role_id',
        'no_sib',
        'berlaku',
        'status',
        'npr',
        'is_active',
        'keahlian',
        'foto_profil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ketersediaanSdm()
    {
        return $this->belongsToMany(KetersediaanSdm::class, 'ketersediaan_sdm_users');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function jenisPekerja()
    {
        return $this->belongsToMany(JenisPekerja::class, 'jenis_pekerja_user', 'user_id', 'jenis_pekerja_id')
                    ->withTimestamps();
    }

    /**
     * Get the pemantauan dosis tld records for the user.
     */
    public function pemantauanDosisTld()
    {
        return $this->hasMany(PemantauanDosisTld::class);
    }

    /**
     * Get the pemantauan dosis pendose records for the user.
     */
    public function pemantauanDosisPendose()
    {
        return $this->hasMany(PemantauanDosisPendose::class);
    }
}

