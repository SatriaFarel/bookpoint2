<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    use SoftDeletes; // wajib ini

    protected $fillable = [
        // 'nik',
        'name',
        'email',
        'password',
        'no_rekening',
        'role',
        'image',
        'is_active',
        'otp',
        'otp_expired',
    ];

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

    // tambahkan ini

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return null; // fallback ke huruf kalau kosong
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() !== 'admin') {
            return false;
        }

        return in_array($this->role, ['admin', 'seller'], true);
    }

    protected static function booted()
    {
        static::updated(function (self $user) {
            if (! $user->wasChanged('image')) {
                return;
            }

            $oldImage = $user->getOriginal('image');

            if ($oldImage && $oldImage !== $user->image && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        });

        static::deleting(function (self $user) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
        });
    }

    public function scopeSeller($query)
    {
        return $query->where('role', 'seller');
    }

    public function scopeCustomer($query)
    {
        return $query->where('role', 'customer');
    }
}
