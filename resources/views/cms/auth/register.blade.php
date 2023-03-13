@extends('cms.layouts.auth')

@section('title')
    Register | CMS
@endsection

@section('css')
@endsection

@section('content')
<div class="pt-4 pb-2">
    <h5 class="card-title text-center pb-0 fs-4">Buat Akun</h5>
    <p class="text-center small">Masukkan detail akun anda.</p>
</div>

<form class="row g-3" id="register-form">
    <div class="col-12">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" id="nama" required>
    </div>

    <div class="col-12">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" required>
    </div>

    <div class="col-12">
        <label for="nohp" class="form-label">No. HP</label>
        <input type="text" name="nohp" class="form-control" id="nohp" required>
    </div>

    <div class="col-12">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" required>
    </div>

    <div class="col-12">
        <label for="password" class="form-label">Konfirmasi Password</label>
        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
    </div>

    <div class="col-12">
        <button class="btn btn-primary w-100" type="submit" id="btn-submit">Daftar</button>
    </div>
    <div class="col-12">
        <p class="small mb-0">Sudah punya akun? <a href="{{ url('/cms/auth/login') }}">Masuk</a></p>
    </div>
</form>
@endsection

@section('js')
<script src="{{ asset('cms/assets/js/auth/register.js'. '?time=' . date("Ymdhisu")) }}"></script>
@endsection