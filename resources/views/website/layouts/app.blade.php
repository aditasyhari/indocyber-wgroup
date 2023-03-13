<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('website/assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('website/assets/css/style.css') }}" type="text/css">

    @yield('css')

</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="#"><span class="icon_heart_alt"></span>
                <div class="tip">2</div>
            </a></li>
            <li><a href="#"><span class="icon_bag_alt"></span>
                <div class="tip">2</div>
            </a></li>
        </ul>
        <div class="offcanvas__logo">
            <a href="./index.html"><img src="{{ asset('cms/assets/img/logo.png') }}" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div>
    </div>

    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-1">
                    <div class="header__logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('cms/assets/img/logo.png') }}" alt="" style="max-height: 80px;">
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="{{ url('/') }}">Produk</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header__right">
                        @if(Auth::check() && Auth::user()->akses == 1)
                            <div class="header__right__auth">
                                <a href="#">{{ Auth::user()->nama }}</a><br>
                                <a href="#">{{ Auth::user()->email }}</a>
                            </div>
                            
                            <ul class="header__right__widget">
                                <li>
                                    <a href="{{ url('/cart/list') }}">
                                        <span class="icon_bag_alt"></span>
                                        <div class="tip" id="tip-total-cart">{{ $totalCart }}</div>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <div class="header__right__auth">
                                <a href="#" data-toggle="modal" data-target="#loginModal">Masuk</a>
                                <a href="#" data-toggle="modal" data-target="#registerModal">Daftar</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright__text">
                        <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="login-form">
                <div class="modal-body">
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                </div>
                <div class="modal-footer w-100">
                    <button type="submit" class="btn btn-primary w-100" id="btn-submit-login">Masuk</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="register-form">
                <div class="modal-body">
                    <div class="col-12">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" required>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="nohp" class="form-label">No. HP</label>
                        <input type="text" name="nohp" class="form-control" id="nohp" required>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" required></textarea>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password-register" required>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="password" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer w-100">
                    <button type="submit" class="btn btn-primary w-100" id="btn-submit-register">Daftar</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('website/assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('website/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="{{ asset('website/assets/js/main.js') }}"></script>
    <script src="{{ asset('website/assets/js/global.js') }}"></script>
    <script src="{{ asset('website/assets/js/auth.js') }}"></script>

    @yield('js')

</body>

</html>