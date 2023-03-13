<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;
use Validator;
use Image;

class ProductController extends Controller
{
    public function list()
    {
        return view('cms.product.list-product');
    }

    public function listData(Request $request)
    {
        $data = Product::latest();
        $data = DataTables::of($data)->addIndexColumn()->make(true);

        return $data;
    }

    public function checkProductName(Request $request)
    {
        $id         = $request->id;
        $nama       = $request->nama_produk;
        $product    = Product::where('nama_produk', $nama)
                      ->when($id, fn ($sql, $id) => $sql->where('id', '!=', $id))
                      ->first();

        return response()->json(!$product, 200);
    }

    public function detail($id)
    {
        $data = Product::findOrFail($id);

        return view('cms.product.detail-product', compact('data'));
    }

    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'nama_produk'   => 'required|unique:tbl_produk',
            'gambar'        => 'required|image|mimes:jpeg,png,jpg|max:5000',
            'stok'          => 'required|numeric',
            'harga'         => 'required'
        ]);

        if($validateData->fails()) {
            return response()->json([
                'code'      => 400,
                'message'   => $validateData->errors()
            ], 400);
        }

        $input = [
            'nama_produk' => $request->nama_produk,
            'stock' => $request->stok,
            'harga' => intval(trim(preg_replace('/\D/', '', $request->harga)))
        ];

        if($request->hasFile('gambar')) {
            $file       = $request->file('gambar');
            $filename   = time() . '.' . $file->getClientOriginalExtension();
            $path       = public_path('uploads/product/');

            $file->move($path, $filename);
            $input['image'] = $filename;
        }

        Product::create($input);

        return response()->json([
            'code'      => 201,
            'message'   => 'Berhasil menambahkan produk!',
        ], 201);
    }

    public function update(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'id'            => 'required',
            'nama_produk'   => 'required|unique:tbl_produk,nama_produk,'.$request->id.',id',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'stok'          => 'required|numeric',
            'harga'         => 'required'
        ]);

        if($validateData->fails()) {
            return response()->json([
                'code'      => 400,
                'message'   => $validateData->errors()
            ], 400);
        }

        $input = [
            'nama_produk' => $request->nama_produk,
            'stock' => $request->stok,
            'harga' => intval(trim(preg_replace('/\D/', '', $request->harga)))
        ];

        if($request->hasFile('gambar')) {
            $file       = $request->file('gambar');
            $filename   = time() . '.' . $file->getClientOriginalExtension();
            $path       = public_path('uploads/product/');

            $file->move($path, $filename);
            $input['image'] = $filename;
        }

        Product::find($request->id)->update($input);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil memperbarui produk!',
        ], 200);
    }

    public function delete(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if($validateData->fails()) {
            return response()->json([
                'code'      => 400,
                'message'   => $validateData->errors()
            ], 400);
        }

        Product::destroy($request->id);

        return response()->json([
            'code'      => 200,
            'message'   => 'Berhasil hapus product!',
        ], 200);
    }
}
