<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CastController extends Controller
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
        $cast = Cast::all();

        return response()->json([
            'message' => 'Berhasil Tampil semua cast',
            'data' => $cast
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'bio' => 'required'
        ]);

        Cast::create([
            'name' => $request->input("name"),
            'age' => $request->input("age"),
            'bio' => $request->input("bio")
        ]);

        return response([
            'message' => 'Berhasil tambah cast'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            return response([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response([
            'message' => 'Detail Data Cast',
            'data' => $cast
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cast = Cast::find($id);

        $cast->name = $request->input('name');
        $cast->age = $request->input('age');
        $cast->bio = $request->input('bio');

        $cast->save();

        return response([
            'message' => 'Update Cast berhasil'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cast = Cast::find($id);

        $cast->delete();
        return response([
            'message' => 'berhasil Menghapus Cast'
        ], 200);
    }
}
