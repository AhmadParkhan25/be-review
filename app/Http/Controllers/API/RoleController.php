<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $role = Role::get()->select('id', 'name');
        return response([
            'message' => 'Data berhasil ditampilkan',
            'data' => $role
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

        $role = new Role;
        $role->name = $request->input('name');
        $role->save();

        return response([
            'message' => 'Data berhasil ditambahkan',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response([
            'message' => 'Detail Data Role',
            'data' => $role
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required'
        ]);
        $role->name = $request->input('name');
        $role->save();

        return response([
            'message' => 'Data berhasil Diupdate'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();
        return response([
            'message' => 'Data Detail berhasil Dihapus'
        ], 200);
    }
}
