<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('cms.auth.login');
    }

    public function loginPost(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'email'     => 'required|string|email|max:50',
            'password'  => 'required|string'
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'code'      => 400,
                'message'   => $validateData->errors()
            ], 400);
        }

        $email      = $request->email;
        $password   = $request->password;

        $user = User::where('email', $email)->where('akses', 0)->first();

        if(!$user) {
            return response()->json([
                'code'      => 404,
                'message'   => 'Email belum terdaftar!'
            ], 404);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'code'      => 401,
                'message'   => 'Password salah!'
            ], 401);
        }

        Auth::login($user);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil masuk!'
        ], 200);
    }

    public function register()
    {
        return view('cms.auth.register');
    }

    public function registerPost(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:50|unique:tbl_user',
            'nohp'      => 'required|numeric',
            'password'  => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'confirm_password' => 'required|same:password'
        ]);

        if($validateData->fails()) {
            return response()->json([
                'code'      => 400,
                'message'   => $validateData->errors()
            ], 400);
        }

        $user = User::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'nohp'      => $request->nohp,
            'akses'     => 0
        ]);

        Auth::login($user);

        return response()->json([
            'code'      => 201,
            'message'   => 'Berhasil daftar!',
        ], 201);
    }

    public function logout(Request $request)
    {
        if($request->ajax()) {
            Auth::logout();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil keluar'
            ], 200);
        }
    }

}
