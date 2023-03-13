<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Validator;
use Auth;

class CartController extends Controller
{
    public function list(Request $request)
    {
        $cart = Cart::leftJoin('tbl_produk as p', 'p.id', '=', 'tbl_keranjang.id_produk')
                ->where('id_user', Auth::user()->id)
                ->where('status_checkout', 'Tidak')
                ->orderBy('tbl_keranjang.id', 'desc')
                ->get();

        $totalCart = count($cart);

        return view('website.cart.list', compact('cart', 'totalCart'));
    }

    public function add(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'qty'           => 'required|numeric|min:1',
            'id_produk'     => 'required'
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'code'      => 400,
                'message'   => $validateData->errors()
            ], 400);
        }

        $id_user    = Auth::user()->id;
        $id_produk  = $request->id_produk;
        $qty        = $request->qty;

        $product = Product::findOrFail($id_produk);

        if($qty > $product->stock) {
            return response()->json([
                'code'      => 409,
                'message'   => 'Quantity (qty) melebihi stock'
            ], 409);
        }

        Cart::create([
            'id_user'   => $id_user,
            'id_produk' => $id_produk,
            'qty'       => $qty,
            'status_checkout' => 'Tidak'
        ]);

        $totalCart = Cart::where('id_user', Auth::user()->id)->where('status_checkout', 'Tidak')->count();

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil masukkan keranjang!',
            'totalCart' => $totalCart
        ], 200);
    }

    public function checkout()
    {
        $id_user = Auth::user()->id;
        Cart::where('id_user', $id_user)
                ->where('status_checkout', 'Tidak')
                ->update([
                    'status_checkout' => 'Ya'
                ]);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil checkout!',
        ], 200);
    }
}
