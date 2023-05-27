<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $fillable = ['judul', 'stok', 'sampul', 'slug', 'penulis', 'kode_buku', 'penerbit_id', 'tahun_terbit'];

    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class);
    }


    public function buku()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    // mutator
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucfirst($value);
    }
   
    public function setPenulisAttribute($value)
    {
        $this->attributes['penulis'] = ucfirst($value);
    }

    public function setTahunAttribute($value)
    {
        $this->attributes['tahun_terbit'] = ucfirst($value);
    }
}
