<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'penulis',
        'foto_cover',
        'tanggal_posting',
        'status'
    ];

    protected $casts = [
        'tanggal_posting' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul);
        });

        static::updating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul);
        });
    }

    // Accessor untuk excerpt
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->isi), 150);
    }

    // Accessor untuk tanggal format Indonesia
    public function getTanggalPostingFormattedAttribute()
    {
        return $this->tanggal_posting->translatedFormat('d F Y');
    }

    // Scope untuk artikel publish
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }
}
