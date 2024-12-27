<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(['isadmin', 'auth:api'])->except('index', 'show',);
    }

    public function index()
    {
        $movie = Movie::all();

        return response([
            'message' => 'tampil data berhasil',
            'data' => $movie
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'year' => 'required'
        ], [
            'required' => 'inputan: attribute harus diisi tidak boleh kosong',
            'mimes' => 'inputan: attribute harus berformat jpeg,png,jpg,gif',
            'poster' => 'inputan: attribut harus berupa gambar',
            'exist' => 'inputan: attribute tidak di temukan di table genres'
        ]);

        $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
            'folder' => 'image',
        ])->getSecurePath();

        $movie = new Movie;

        $movie->title = $request->input('title');
        $movie->summary = $request->input('summary');
        $movie->poster = $uploadedFileUrl;
        $movie->genre_id = $request->input('genre_id');
        $movie->year = $request->input('year');
        $movie->save();


        return response([
            'message' => 'Tambah Movie berhasil'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::find($id);
        if (!$movie) {
            return response([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response([
            'message' => 'Detail Data Movie',
            'data' => $movie
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'summary' => 'required|min:10',
            'poster' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'year' => 'required'
        ], [
            'min' => 'inputan: attribute minimal 10 karakter',
            'required' => 'inputan: attribute harus diisi tidak boleh kosong',
            'mimes' => 'inputan: attribute harus berformat jpeg,png,jpg,gif',
            'poster' => 'inputan: attribut harus berupa gambar',
            'exist' => 'inputan: attribute tidak di temukan di table genres'
        ]);

        $movie = Movie::find($id);

        if ($request->hasFile('image')) {
            $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
                'folder' => 'image',
            ])->getSecurePath();
            $movie->poster = $uploadedFileUrl;
        }

        if (!$movie) {
            return response([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }


        $movie->title = $request->title;
        $movie->summary = $request->summary;
        $movie->genre_id = $request->genre_id;
        $movie->year = $request->year;
        $movie->save();

        return response([
            'message' => 'Update Movie berhasil'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);

        $movie->delete();
        return response([
            'message' => 'berhasil Menghapus movie'
        ], 200);
    }
}
