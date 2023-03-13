@extends('cms.layouts.app')

@section('title')
    List Product | CMS
@endsection

@section('css')
@endsection

@section('content')
<div class="pagetitle">
    <h1>Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Cms</a></li>
            <li class="breadcrumb-item"><a href="#">Produk</a></li>
            <li class="breadcrumb-item active">Daftar Produk</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Produk</h5>
                    <p>Berikut ini adalah daftar produk.</p>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">Tambah Produk</button>

                    <table class="table datatable" id="table-data">
                        <thead>
                            <tr>
                                <th scope="col" width="5" class="text-start">No</th>
                                <th scope="col" width="20" class="text-start">Gambar</th>
                                <th scope="col" class="text-start">Produk</th>
                                <th scope="col" class="text-start">Stok</th>
                                <th scope="col" class="text-start">Harga</th>
                                <th scope="col" class="text-start"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambah-produk-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama-produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama-produk" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar-produk" class="form-label">Gambar (Maks. 5 mb)</label>
                        <input type="file" class="form-control" id="gambar-produk" name="gambar" required accept="image/jpeg,image/png">
                    </div>
                    <div class="mb-3">
                        <label for="stok-produk" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok-produk" name="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga-produk" class="form-label">Harga (Rp)</label>
                        <input type="text" class="form-control text-number" id="harga-produk" name="harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-tambah">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Produk -->
<div class="modal fade" id="updateProdukModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="update-produk-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama-produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama-produk-edit" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar-produk" class="form-label">Gambar (Maks. 5 mb) (Opsional)</label>
                        <input type="file" class="form-control" id="gambar-produk-edit" name="gambar" accept="image/jpeg,image/png">
                    </div>
                    <div class="mb-3">
                        <label for="stok-produk" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok-produk-edit" name="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga-produk" class="form-label">Harga (Rp)</label>
                        <input type="text" class="form-control text-number" id="harga-produk-edit" name="harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id-product-edit" name="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-update">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('cms/assets/js/product/list.js'. '?time=' . date("Ymdhisu")) }}"></script>
@endsection