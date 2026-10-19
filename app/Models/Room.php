<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'capacity',
        'building',
        'facilities',
        'image',
        'description',
        'status',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    /**
     * Get array list of facilities from comma/newline-separated string
     */
    public function getFacilitiesListAttribute(): array
    {
        if (empty($this->facilities)) {
            return [];
        }
        $items = preg_split('/[\r\n,]+/', $this->facilities);
        return array_values(array_filter(array_map('trim', $items)));
    }

    /**
     * Resolve image URL or return attractive placeholder
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1517502884422-41eaead166d4?auto=format&fit=crop&w=800&q=80';
    }
}
