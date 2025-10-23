<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'no_hp',
        'email',
        'alamat',
        'foto'
    ];

    // Accessor untuk foto URL
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/default-avatar.jpg');
    }

    // Accessor untuk jabatan singkat
    public function getJabatanSingkatAttribute()
    {
        $jabatan = strtolower($this->jabatan);

        if (str_contains($jabatan, 'ketua')) {
            return 'Ketua';
        } elseif (str_contains($jabatan, 'sekretaris')) {
            return 'Sekretaris';
        } elseif (str_contains($jabatan, 'bendahara')) {
            return 'Bendahara';
        }

        return $this->jabatan;
    }
}
