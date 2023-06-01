<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Buku;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BukuControllers extends Controller
{
    public $kode_buku;

    public function getBuku()
    {
        return response()->json([
                'message'   => 'Berhasil Mengambil Data Buku',
                'data'      => Buku::all()
                ], 200);
    }

    public function getBukuCode($kode_buku)
    {
        $buku = Buku::where('kode_buku', $kode_buku)
        ->take(1)
        ->get();

        return response()->json(array(
        'status' => 'success',
        'data' => $buku->toArray()),
        200
        );
    }

    // API POST TAMBAH BUKU

     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = Buku::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required',
            'kode_buku' => 'required',
            'tahun_terbit' => 'required',
            'penerbit_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Buku::create([
            'sampul' => $request->sampul,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'stok' => $request->stok,
            'kode_buku' => $request->kode_buku,
            'tahun_terbit' => $request->tahun_terbit,
            'penerbit_id' => $request->penerbit_id,
            'slug' => Str::slug($request->judul)
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Data Buku Berhasil Ditambahkan',
            ], 200);

    }

    public function ubah(Request $request)
    {
        try {
            $data = Buku::where('kode_buku', $request->kode_buku)->first();
            if($data != NULL){
                Buku::where('kode_buku', $request->kode_buku)->update([
                    'sampul'     => $request->sampul,
                    'judul' => $request->judul,
                    'penulis' => $request->penulis,
                    'stok' => $request->stok,
                    'kode_buku' => $request->kode_buku,
                    'tahun_terbit' => $request->tahun_terbit,
                    'penerbit_id' => $request->penerbit_id,
                ]);
                return response()->json([
                    'code' => 200,
                    'message' => 'Data Buku Berhasil Diubah',
                    ], 200);
            }else{
                return response()->json([
                    'code' => 400,
                    'message' => 'Data Buku Tidak Ditemukan',
                    ], 200);    
            }
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 400,
                'message' => (string)$e,
                ], 200);
        }

    }

    public function delete(Request $request)
    {
        try {
            $data = Buku::where('kode_buku', $request->kode_buku)->first();
            if($data != NULL){
                Buku::where('kode_buku', $request->kode_buku)->delete();
                return response()->json([
                    'code' => 200,
                    'message' => 'Data Buku Berhasil Dihapus',
                    ], 200);
            }else{
                return response()->json([
                    'code' => 400,
                    'message' => 'Data Buku Tidak Ditemukan',
                    ], 200);    
            }
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 400,
                'message' => (string)$e,
                ], 200);
        }
       
    }

   
}
