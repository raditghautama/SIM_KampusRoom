<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'identity_number',
        'no_hp',
        'email',
        'password',
        'role',
        'user_type',
        'department',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeminjam(): bool
    {
        return $this->role === 'peminjam';
    }

    public function isMahasiswa(): bool
    {
        return $this->user_type === 'mahasiswa' || ($this->role === 'peminjam' && $this->user_type !== 'dosen');
    }

    public function isDosen(): bool
    {
        return $this->user_type === 'dosen';
    }

    public function getUserTypeLabelAttribute(): string
    {
        return match($this->user_type) {
            'dosen' => 'Dosen',
            'mahasiswa' => 'Mahasiswa',
            'tendik' => 'Tenaga Kependidikan',
            'admin' => 'Admin Sarpras',
            default => ucfirst($this->role ?? 'Peminjam'),
        };
    }

    public function getUserTypeBadgeAttribute(): string
    {
        return match($this->user_type) {
            'admin' => 'bg-danger-subtle text-danger-emphasis border border-danger-subtle',
            'dosen' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
            'tendik' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
            default => 'bg-primary-subtle text-primary-emphasis border border-primary-subtle',
        };
    }

    public function getIdentifierAttribute(): ?string
    {
        return $this->identity_number;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->no_hp;
    }

    /**
     * Format phone number for WhatsApp URL (e.g. 08123... -> 628123...)
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        $phone = $this->no_hp ?? $this->phone ?? null;
        if (!$phone) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '0')) {
            return '62' . substr($clean, 1);
        }
        if (str_starts_with($clean, '8')) {
            return '62' . $clean;
        }
        return $clean;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
