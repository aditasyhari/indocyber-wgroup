@extends('cms.layouts.app')

@section('title')
    Detail Product | CMS
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
            <li class="breadcrumb-item active">Detail Produk</li>
        </ol>
    </nav>
</div>

<a href="{{ url('/cms/product/list') }}" class="btn btn-primary mb-3 mt-3">
    <i class="bi bi-arrow-left-short"></i>
    Kembali
</a>

<section class="section">
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <img src="{{ url('/uploads/product/'.$data->image) }}" alt="Gambar Produk" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <div class="mt-3">
                        <h3>{{ $data->nama_produk }}</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Jumlah Stok</div>
                        <div class="col-lg-9 col-md-8">{{ $data->stock }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label">Harga</div>
                        <div class="col-lg-9 col-md-8">Rp {{ number_format($data->harga, 0, ".", ".") }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label">Tanggal Dibuat</div>
                        <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label">Terakhir Diperbarui</div>
                        <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($data->updated_at)->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('cms/assets/js/product/detail.js'. '?time=' . date("Ymdhisu")) }}"></script>
@endsection