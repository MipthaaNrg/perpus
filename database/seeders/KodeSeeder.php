<?php

namespace Database\Seeders;

use App\Models\Kode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kode = ['none','000 - Komputer', '100 - Sejarah', '200 - Biografi', '300 - Novel', '400 - Komik'];

        foreach ($kode as $value) {
            Kode::create([
                'nama' => $value,
                'slug' => Str::slug($value)
            ]);
        }
       
    }
}
