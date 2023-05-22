<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

    public function hasRole($role)
    {
        return $this->role->name == $role;
    }

    public function scopeAdmin()
    {
        return $this->role_id = 1;
    }

    public function scopeUserAccount()
    {
        return $this->role_id = 2;
    }

    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'aktif':
                $color = 'success';
                break;

            case 'tidak aktif':
                $color = 'danger';
                break;

            default:
                break;
        }
        return $color;
    }

    public function statusText()
    {
        $text = '';

        switch ($this->status) {
            case 'aktif':
                $text = 'Aktif';
                break;

            case 'tidak aktif':
                $text = 'Tidak Aktif';
                break;

            default:
                break;
        }
        return $text;
    }
}
