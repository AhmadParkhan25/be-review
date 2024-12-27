<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CastMovie;
use Illuminate\Http\Request;

class CastMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['isadmin', 'auth:api'])->except('index', 'show');
    }
    public function index()
    {
        $castMovie = CastMovie::all();
        return response([
            'message' => 'Berhasil Tampil cast Movie',
            'data' => $castMovie
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'cast_id' => 'required|exists:casts,id',
                'movie_id' => 'required|exists:movies,id'
            ],
            [
                'required' => 'inputan: attribute harus diisi jangan kosong',
                'exists' => 'data tidak ada'
            ]
        );

        CastMovie::create([
            'name' => $request->name,
            'cast_id' => $request->cast_id,
            'movie_id' => $request->movie_id
        ]);

        return response([
            'message' => 'berhasil tambah cast Movie'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $castMovie = CastMovie::findOrFail($id);
        return response([
            'message' => 'Berhasil Tampil cast Movie',
            'data' => $castMovie
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $castMovie = CastMovie::find($id);
        $castMovie->name = $request->name;
        $castMovie->cast_id = $request->cast_id;
        $castMovie->movie_id = $request->movie_id;
        $castMovie->save();

        return response([
            'message' => 'Berhasil Update cast Movie'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $castMovie = CastMovie::findOrFail($id);
        $castMovie->delete();
        return response([
            'message' => 'Berhasil Delete cast Movie'
        ]);
    }
}
