<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateOrCreate(Request $request)
    {
        $user = auth()->user();

        $request->validate(
            [
                'age' => 'required|integer',
                'biodata' => 'required',
                'address' => 'required',
            ],
            [
                'required' => 'inputan: attritbute harus diisi tidak boleh kosong',
                'number' => 'inputan: attribute harus berupa number'
            ]
        );


        $profile = Profile::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'age' => $request->age,
                'biodata' => $request->biodata,
                'address' => $request->address
            ]
        );

        return response([
            'message' => 'Profile berhasil diubah',
            'data' => $profile
        ], 201);
    }
}
