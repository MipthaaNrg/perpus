<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function getBuku()
    {
        return response()->json([
                'message'   => 'success',
                'data'      => Buku::all()
                ], 200);
    }
}
