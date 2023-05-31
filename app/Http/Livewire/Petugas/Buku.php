<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Buku as ModelsBuku;
use App\Models\Kode;
use App\Models\Penerbit;
// use App\Models\Rak;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Buku extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    use WithFileUploads;

    public $create, $edit, $delete, $show;
    public $kode, $rak, $penerbit;
    public $kode_buku, $rak_id, $penerbit_id, $baris;
    public $judul, $stok, $penulis, $tahun, $tahun_terbit, $sampul, $buku_id, $search;

    protected $rules = [
        'judul' => 'required',
        'penulis' => 'required',
        'stok' => 'required|numeric|min:1',
        'tahun_terbit' => 'required|numeric|min:1',
        'sampul' => 'required|image|max:1024',
        'kode_buku' => 'required',
        // 'rak_id' => 'required|numeric|min:1',
        'penerbit_id' => 'required|numeric|min:1',
    ];

    protected $validationAttributes = [
        'kode_buku' => 'kode',
        // 'rak_id' => 'rak',
        'penerbit_id' => 'penerbit',
    ];

    // public function pilihKode()
    // {
    //     $this->rak = Rak::where('kode_buku', $this->kode_buku)->get();
    // }

    public function create()
    {
        $this->format();

        $this->create = true;
        $this->kode = Kode::all();
        $this->penerbit = Penerbit::all();
    }

    public function store()
    {
        $this->validate();

        $this->sampul = $this->sampul->store('buku', 'public');

        ModelsBuku::create([
            'sampul' => $this->sampul,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'stok' => $this->stok,
            'kode_buku' => $this->kode_buku,
            'tahun_terbit' => $this->tahun_terbit,
            // 'rak_id' => $this->rak_id,
            'penerbit_id' => $this->penerbit_id,
            'slug' => Str::slug($this->judul)
        ]);

        session()->flash('sukses', 'Data berhasil ditambahkan.');
        $this->format();
    }

    public function show(ModelsBuku $buku)
    {
        $this->format();

        $this->show = true;
        $this->judul = $buku->judul;
        $this->sampul = $buku->sampul;
        $this->penulis = $buku->penulis;
        $this->stok = $buku->stok;
        $this->tahun = $buku->tahun;
        $this->tahun_terbit = $buku->tahun_terbit;
        $this->kode = $buku->kode;
        $this->kode_buku = $buku->kode_buku;
        $this->penerbit = $buku->penerbit->nama;
        // $this->rak = $buku->rak->rak;
        // $this->baris = $buku->rak->baris;
    }

    public function edit(ModelsBuku $buku)
    {
        $this->format();

        $this->edit = true;
        $this->buku_id = $buku->id;
        $this->judul = $buku->judul;
        $this->penulis = $buku->penulis;
        $this->stok = $buku->stok;
        $this->kode_buku = $buku->kode_buku;

        // $this->tahun = $buku->$tahun;
        $this->tahun_terbit = $buku->tahun_terbit;
        // $this->rak_id = $buku->rak_id;
        $this->penerbit_id = $buku->penerbit_id;
        $this->kode = Kode::all();
        // $this->rak = Rak::where('kode_buku', $buku->kode_buku)->get();
        $this->penerbit = Penerbit::all();
    }

    public function update(ModelsBuku $buku)
    {
        $validasi = [
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|numeric|min:1',
            'kode_buku' => 'required',
            'tahun_terbit' => 'required|numeric|min:1',
            'penerbit_id' => 'required|numeric|min:1',
        ];

        if ($this->sampul) {
            $validasi['sampul'] = 'required|image|max:1024';
        }

        $this->validate($validasi);

        if ($this->sampul) {
            Storage::disk('public')->delete($buku->sampul);
            $this->sampul = $this->sampul->store('buku', 'public');
        } else {
            $this->sampul = $buku->sampul;
        }

        $buku->update([
            'sampul' => $this->sampul,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'stok' => $this->stok,
            'kode_buku' => $this->kode_buku,
            'tahun_terbit' => $this->tahun_terbit,
            // 'rak_id' => $this->rak_id,
            'penerbit_id' => $this->penerbit_id,
            'slug' => Str::slug($this->judul)
        ]);

        session()->flash('sukses', 'Data berhasil diubah.');
        $this->format();
    }

    public function delete(ModelsBuku $buku)
    {
        $this->format();

        $this->delete = true;
        $this->buku_id = $buku->id;
    }

    public function destroy(ModelsBuku $buku)
    {
        Storage::disk('public')->delete($buku->sampul);
        $buku->delete();

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
            $buku = ModelsBuku::latest()->where('judul', 'like', '%'. $this->search .'%')->paginate(5);
        } else {
            $buku = ModelsBuku::latest()->paginate(5);
        }
        
        return view('livewire.petugas.buku', compact('buku'));
    }

    public function format()
    {
        unset($this->create);
        unset($this->delete);
        unset($this->edit);
        unset($this->show);
        unset($this->buku_id);
        unset($this->judul);
        unset($this->sampul);
        unset($this->stok);
        unset($this->penulis);
        unset($this->kode);
        unset($this->penerbit);
        // unset($this->rak);
        // unset($this->rak_id);
        unset($this->penerbit_id);
        unset($this->kode_buku);
        unset($this->tahun_terbit);
        unset($this->tahun);
    }
}
