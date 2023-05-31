<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penerbit;
class PenerbitController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = Penerbit::latest()->paginate(5);

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
            'nama'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Penerbit::create([
            'nama'     => $request->nama,
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            ], 200);

    }
}
