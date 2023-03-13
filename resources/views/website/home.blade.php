@extends('website.layouts.app')

@section('title') Product | Website @endsection

@section('content')
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Daftar Produk</h4>
                </div>
            </div>
        </div>
        <div class="row property__gallery">
            @foreach($product as $p)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{ asset('uploads/product/'.$p->image) }}">
                        <ul class="product__hover">
                            <li>
                                <a href="{{ asset('uploads/product/'.$p->image) }}" class="image-popup"><span class="arrow_expand"></span></a>
                            </li>
                            <li>
                                @if(Auth::check() && Auth::user()->akses == 1)
                                    <a href="#" class="bag" data-toggle="modal" data-id="{{ $p->id }}" data-product="{{ $p->nama_produk }}" data-image="{{ asset('uploads/product/'.$p->image) }}" data-price="{{ $p->harga }}" data-stock="{{ $p->stock }}" data-qty="{{ $p->qty }}" data-target="#cartModal"><span class="icon_bag_alt"></span></a>
                                @else
                                    <a href="#" onclick="swalWarning('Silahkan masuk terlebih dahulu!')"><span class="icon_bag_alt"></span></a>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">{{ $p->nama_produk }}</a></h6>
                        <div class="product__price mt-2">Rp {{ number_format($p->harga, 0, '.', '.') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>

        {{ $product->links('pagination::bootstrap-4') }}

    </div>
</section>

<!-- Modal Cart -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">Keranjang</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cart-form">
            <div class="modal-body">
                <div class="col-12">
                    <label for="" class="font-weight-bold">Produk</label>
                    <div class="cart__product__item d-flex">
                        <div style="max-width: 100px !important;">
                            <img src="" id="cart-image" alt="gambar produk">
                        </div>
                        <div class="cart__product__item__title mx-2">
                            <h6 id="cart-product">-</h6>
                            <div class="rating">
                                Stok <span id="cart-stock">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <label for="" class="font-weight-bold">Harga</label>
                    <div class="cart__price" id="cart-price">Rp 0</div>
                </div>
                <div class="col-12 mt-2">
                    <label for="" class="font-weight-bold">Qty</label>
                    <div class="cart__quantity">
                        <div class="pro-qty">
                            <input type="number" value="1" min="1" name="qty" id="cart-qty" required>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id_produk" id="cart-id-product">
            </div>
            <div class="modal-footer w-100">
                <button type="submit" class="btn btn-primary w-100" id="btn-submit-cart">Masukkan Keranjang</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('website/assets/js/home.js'. '?time=' . date("Ymdhisu")) }}"></script>
@endsection