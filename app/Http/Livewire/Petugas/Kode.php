<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Buku;
use App\Models\Kode as ModelsKode;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Kode extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $create, $edit, $delete;
    public $nama, $kode_buku, $search;

    protected $rules = [
        'nama' => 'required',
    ];

    public function create()
    {
        $this->create = true;
    }

    public function store()
    {
        $this->validate();

        ModelsKode::create([
            'nama' => $this->nama,
            'slug' => Str::slug($this->nama)
        ]);

        session()->flash('sukses', 'Data berhasil ditambahkan.');
        $this->format();
    }

    public function edit(ModelsKode $kode)
    {
        $this->format();

        $this->edit = true;
        $this->nama = $kode->nama;
        $this->kode_buku = $kode->nama;
    }

    public function update(ModelsKode $kode)
    {
        $this->validate();

        $kode->update([
            'nama' => $this->nama,
            'slug' => Str::slug($this->nama)
        ]);

        session()->flash('sukses', 'Data berhasil diubah.');
        $this->format();
    }

    public function delete(ModelsKode $kode)
    {
        $this->delete = true;
        $this->kode_buku = $kode->nama;
    }

    public function destroy(ModelsKode $kode)
    {
        $buku = Buku::where('kode_buku', $kode->nama)->get();
        foreach ($buku as $key => $value) {
            $value->update([
                'kode_buku' => 1
            ]);
        }
        $kode->delete();

        session()->flash('sukses', 'Data berhasil dihapus.');
        $this->format();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->search) {
            $kode = ModelsKode::latest()->where('nama', 'like', '%'. $this->search .'%')->paginate(5);
        } else {
            $kode = ModelsKode::latest()->paginate(5);
        }
        
        return view('livewire.petugas.kode', [
            'kode' => $kode
        ]);
    }

    public function format()
    {
        unset($this->create);
        unset($this->edit);
        unset($this->delete);
        unset($this->nama);
        unset($this->kode_buku);
    }
}
