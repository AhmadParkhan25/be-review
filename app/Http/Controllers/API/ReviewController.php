<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function updateOrCreate(Request $request)
    {
        $user = auth()->user();
        $request->validate(
            [
                'critic' => 'required',
                'rating' => 'required|max:5',
                'movie_id' => 'required|exists:movies,id',
            ],
            [
                'required' => 'inputan: attritbute harus diisi tidak boleh kosong',
                'max' => 'inputan:attribute max 5 karakter',
            ]
        );


        $review = Review::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'movie_id' => $request->movie_id,
                'critic' => $request->critic,
                'rating' => $request->rating
            ]
        );

        return response([
            'message' => 'Review berhasil dibuat/diubah',
            'data' => $review
        ], 201);
    }
}
