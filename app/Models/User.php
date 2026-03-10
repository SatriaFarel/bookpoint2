<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements HasAvatar
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
        'nik',
        'name',
        'email',
        'password',
        'no_rekening',
        'role',
        'image',
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

    protected static function booted()
    {
        static::forceDeleted(function ($product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
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
