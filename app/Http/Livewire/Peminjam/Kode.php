<?php

namespace App\Http\Livewire\Peminjam;

use App\Models\Kode as ModelsKode;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Kode extends Component
{
    protected $listeners = ['tambahKeranjang', 'kurangiKeranjang'];

    public $count;

    public function mount()
    {
        if (auth()->user()) {
            $this->count = DB::table('peminjaman')
                ->join('detail_peminjaman', 'peminjaman.id', '=', 'detail_peminjaman.peminjaman_id')
                ->where('peminjam_id', auth()->user()->id)
                ->where('status', '!=', 3)
                ->count();
        }
    }

    public function pilihKode($id)
    {
        $this->emit('pilihKode', $id);
    }

    public function semuaKode()
    {
        $this->emit('semuaKode');
    }

    public function tambahKeranjang()
    {
        $this->count += 1;
    }

    public function kurangiKeranjang()
    {
        $this->count -= 1;
    }

    public function render()
    {
        return view('livewire.peminjam.kode', [
            'kode' => ModelsKode::where('id', '!=', 1)->get(),
            'count' => $this->count
        ]);
    }
}
