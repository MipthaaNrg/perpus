<?php

namespace App\Http\Livewire\Peminjam;

use App\Models\Buku as ModelsBuku;
use App\Models\DetailPeminjaman;
use App\Models\Kode;
use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Buku extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['pilihKode', 'semuaKode'];

    public $kode_buku, $pilih_kode, $buku_id, $detail_buku, $search;

    public function pilihKode($nama)
    {
        $this->format();
        $this->kode_buku = $nama;
        $this->pilih_kode = true;
        $this->updatingSearch();
    }

    public function semuaKode()
    {
        $this->format();
        $this->pilih_kode = false;
        $this->updatingSearch();
    }

    public function detailBuku($id)
    {
        $this->format();
        $this->detail_buku = true;
        $this->buku_id = $id;
    }

    public function keranjang(ModelsBuku $buku)
    {
        // user harus login
        if (auth()->user()) {
            
            // role peminjam
            if (auth()->user()->hasRole('anggota')) {
               
                $peminjaman_lama = DB::table('peminjaman')
                    ->join('detail_peminjaman', 'peminjaman.id', '=', 'detail_peminjaman.peminjaman_id')
                    ->where('peminjam_id', auth()->user()->id)
                    ->where('status', '!=', 3)
                    ->get();

                // jumlah maksimal 2
                if ($peminjaman_lama->count() == 2) {
                    session()->flash('gagal', 'Buku yang dipinjam maksimal 2');
                } else {

                    // peminjaman belum ada isinya
                    if ($peminjaman_lama->count() == 0) {
                        $peminjaman_baru = Peminjaman::create([
                            'kode_pinjam' => random_int(100000000, 999999999),
                            'peminjam_id' => auth()->user()->id,
                            'status' => 0
                        ]);

                        DetailPeminjaman::create([
                            'peminjaman_id' => $peminjaman_baru->id,
                            'buku_id' => $buku->id
                        ]);

                        $this->emit('tambahKeranjang');
                        session()->flash('sukses', 'Buku berhasil ditambahkan ke dalam keranjang');
                    } else {

                        // buku tidak boleh sama
                        if ($peminjaman_lama[0]->buku_id == $buku->id) {
                            session()->flash('gagal', 'Buku tidak boleh sama');
                        } else {

                            DetailPeminjaman::create([
                                'peminjaman_id' => $peminjaman_lama[0]->peminjaman_id,
                                'buku_id' => $buku->id
                            ]);

                            $this->emit('tambahKeranjang');
                            session()->flash('sukses', 'Buku berhasil ditambahkan ke dalam keranjang');
                        }

                    }

                }

            } else {
                session()->flash('gagal', 'Role user anda bukan Anggota');
            }

        } else {
            session()->flash('gagal', 'Anda harus login terlebih dahulu');
            redirect('/login');
        }
        
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->pilih_kode) {
            if ($this->search) {
                $buku = ModelsBuku::latest()->where('judul', 'like', '%'. $this->search .'%')->where('kode_buku', $this->kode_buku)->paginate(12);
            } else {
                $buku = ModelsBuku::latest()->where('kode_buku', $this->kode_buku)->paginate(12);
            }
            $title = Kode::find($this->kode_buku)->nama;
        }elseif ($this->detail_buku) {
            $buku = ModelsBuku::find($this->buku_id);
            $title = 'Detail Buku';
        } else {
            if ($this->search) {
                $buku = ModelsBuku::latest()->where('judul', 'like', '%'. $this->search .'%')->paginate(12);
            } else {
                $buku = ModelsBuku::latest()->paginate(12);
            }
            $title = 'Semua Buku';
        }
        
        return view('livewire.peminjam.buku', compact('buku', 'title'));
    }

    public function format()
    {
        $this->detail_buku = false;
        $this->pilih_kode = false;
        unset($this->buku_id);
        unset($this->kode_buku);
    }
}
