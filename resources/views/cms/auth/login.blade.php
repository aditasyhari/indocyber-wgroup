@extends('cms.layouts.auth')

@section('title')
    Login | CMS
@endsection

@section('css')
@endsection

@section('content')
<div class="pt-4 pb-2">
    <h5 class="card-title text-center pb-0 fs-4">Masuk ke akun anda</h5>
    <p class="text-center small">Masukkan email dan password anda</p>
</div>

<form class="row g-3 needs-validation" id="login-form">
    <div class="col-12">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" required>
        <div class="invalid-feedback mt-3"></div>
    </div>

    <div class="col-12">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" required>
        <div class="invalid-feedback"></div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary w-100" type="submit" id="btn-submit">Masuk</button>
    </div>
    <div class="col-12">
        <p class="small mb-0">Belum punya akun? <a href="{{ url('/cms/auth/register') }}">Daftar</a></p>
    </div>
</form>
@endsection

@section('js')
<script src="{{ asset('cms/assets/js/auth/login.js'. '?time=' . date("Ymdhisu")) }}"></script>
@endsection