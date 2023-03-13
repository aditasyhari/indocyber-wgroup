@extends('website.layouts.app')

@section('title') Cart List | Website @endsection

@section('content')
<section class="shop-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach($cart as $c)
                                <tr>
                                    <td class="cart__product__item">
                                        <div style="max-width: 150px;">
                                            <img src="{{ asset('uploads/product/'.$c->image) }}" alt="">
                                        </div>
                                        <div class="cart__product__item__title">
                                            <h6>{{ $c->nama_produk }}</h6>
                                            <div class="rating">
                                                Stok <span id="cart-stock">{{ $c->stock }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">Rp {{ number_format($c->harga, 0, '.', '.') }}</td>
                                    <td class="cart__quantity">
                                        <div class="pro-qty">
                                            <input type="number" min="1" value="{{ $c->qty }}">
                                        </div>
                                    </td>
                                    <td class="cart__total">
                                        Rp {{ number_format($c->harga*$c->qty, 0, '.', '.') }}
                                    </td>
                                    <td class="cart__close"><span class="icon_close"></span></td>
                                </tr>
                                @php
                                    $total += $c->harga*$c->qty;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="cart__btn">
                    <a href="{{ url('/') }}">Lanjut Belanja</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="cart__total__procced">
                    <h6>Total</h6>
                    <ul>
                        <li>Subtotal <span>Rp {{ number_format($total, 0, '.', '.') }}</span></li>
                        <li>Total <span>Rp {{ number_format($total, 0, '.', '.') }}</span></li>
                    </ul>
                    <a href="#" class="primary-btn" id="checkout">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('website/assets/js/cart.js'. '?time=' . date("Ymdhisu")) }}"></script>
@endsection