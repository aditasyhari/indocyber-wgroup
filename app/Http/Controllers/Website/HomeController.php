<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
Use Validator;
use Auth;
use Hash;

class HomeController extends Controller
{
    public function home()
    {
        $totalCart = 0;
        $product = Product::orderBy('updated_at', 'desc')->paginate(8);
        if(Auth::check()) {
            $totalCart = Cart::where('id_user', Auth::user()->id)->where('status_checkout', 'Tidak')->count();
        }

        return view('website.home', compact('totalCart', 'product'));
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

        $user = User::where('email', $email)->where('akses', 1)->first();

        if(!$user) {
            return response()->json([
                'code'      => 404,
                'message'   => 'Email tidak ditemukan!'
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

    public function registerPost(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:50|unique:tbl_user',
            'nohp'      => 'required|numeric',
            'alamat'    => 'required',
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
            'alamat'    => $request->alamat,
            'akses'     => 1
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
