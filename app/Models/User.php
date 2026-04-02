<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isSuperAdmin();
        }

        if ($panel->getId() === 'portal') {
            // Check status for ALL users (except Super Admin/National Admin if we want them always active, but better stick to status)
            if ($this->role !== 'super_admin' && $this->role !== 'national_admin' && $this->status !== 'active') {
                return false;
            }
            
            // Also check Huissier profile status if applicable
            if ($this->isHuissier() && $this->huissier && $this->huissier->status !== 'active') {
                return false;
            }

            return $this->isSuperAdmin() || $this->isNationalAdmin() || $this->isRegionalAdmin() || $this->isHuissier();
        }

        return false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'huissier_id',
        'region_id',
        'status',
    ];

    public function huissier()
    {
        return $this->belongsTo(Huissier::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isNationalAdmin(): bool
    {
        return $this->role === 'national_admin';
    }

    public function isRegionalAdmin(): bool
    {
        return $this->role === 'regional_admin';
    }

    public function isHuissier(): bool
    {
        return $this->role === 'huissier';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
