<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak';
    protected $fillable = ['rak', 'baris', 'kode_buku', 'slug'];

    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }

    // accesor
    public function getLokasiAttribute()
    {
        return "Rak : {$this->rak}, Baris : {$this->baris}";
    }
}
