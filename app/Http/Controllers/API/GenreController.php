<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
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
        $genre = Genre::all();
        return response([
            'message' => 'tampil data berhasil',
            'data' => $genre
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Genre::create([
            'name' => $request->name
        ]);

        return response([
            'message' => 'Berhasil tambah genre'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        return response([
            'message' => 'Detail Data Cast',
            'data' => $genre
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::find($id);

        $request->validate([
            'name' => 'required'
        ]);

        $genre = new Genre();
        $genre->name = $request->name;
        $genre->save();

        return response([
            'message' => 'Berhasil melakukan update Genre '
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        $genre->delete();
        return response([
            'message' => 'berhasil Menghapus Genre'
        ], );
    }
}
