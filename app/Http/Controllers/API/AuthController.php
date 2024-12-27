<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\GenerateEmailMail;
use App\Mail\UserRegisterMail;
use App\Models\OtpCode;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,id',
            'password' => 'required|min:8|confirmed',
        ], [
            'required' => 'inputan: attribute harus diisi tidak boleh kosong',
            'email' => 'inputan: attribute harus berupa email',
            'unique' => 'inputan: email sudah terdaftar',
            'confirmed' => 'inputan password dengan dengan confirm password'
        ]);

        $user = new User;
        $roleUser = Role::where('name', 'user')->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = $roleUser->id;
        $user->save();

        Mail::to($user->email)->send(new UserRegisterMail($user));
        return response([
            'message' => 'Register Berhasil',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'required' => 'inputan: attribute harus diisi tidak boleh kosong'
        ]);


        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::with('role')->where('email', $request->input('email'))->first();

        return response([
            'message' => 'user berhasil login',
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function currentUser()
    {
        $user = auth()->user();

        return response()->json([
            'message' => 'berhasil get user',
            'user' => $user
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response([
            'message' => 'Logout Berhasil'
        ], 200);
    }

    public function verifikasiAkun(Request $request)
    {
        $request->validate([
            'otp' => 'required|min:6'
        ],[
            'required' => 'inputan: attribute harus diisi tidak boleh kosong',
            'min' => 'inputan: attribute minimal 6 karakter'
        ]);

        $user = auth()->user();

        $otp_code = OtpCode::where('otp', $request->input('otp'))->where('user_id', $user->id)->first();


        if(!$otp_code){
            return response([
                'message' => 'Otp tidak ditemukan'
            ], 400);
        }

        $now = Carbon::now();
        if(!$now > $otp_code->valid_until){
            return response([
                'message' => 'Otp sudah kadaluarsa silahkan generate ulang'
            ], 400);
        }

        $user = User::find($otp_code->user_id);

        $user->email_verified_at = $now;
        $user->save();

        $otp_code->delete();

        return response([
            'message' => 'berhasil verifikasi akun'
        ], 200);
    }

    public function generateOtpCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ],[
            'required' => 'inputan: attribute harus diisi tidak boleh kosong',
            'email' => 'inputan: attribute harus berupa email'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        $user->otp_generate();

        Mail::to($user->email)->send(new GenerateEmailMail($user));

        return response()->json([
            'message' => 'Otp berhasil di generate'
        ]);
    }

}
