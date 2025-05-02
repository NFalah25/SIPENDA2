<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-social.css') }}">
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <style>
        #app {
            background: url('{{ asset('assets/img/slider-left-dec.png') }}') no-repeat fixed;
            /* background-position: calc(50% - 150px) center; */
            background-position: center center;
            background-size: cover;
        }

        /* #app {
            background: url('{{ asset('assets/img/service-bg.jpg') }}') no-repeat fixed;
            background-position: center center;
            background-size: cover;
        } */

        @media (max-width: 991px) {
            #app {
                background: url('{{ asset('assets/img/service-bg.jpg') }}') no-repeat fixed;
                background-position: center center;
                background-size: cover;
            }
        }


        .glass-card {
            background-color: rgba(255, 255, 255, 0.1);
            /* transparan putih */
            backdrop-filter: blur(10px);
            /* efek blur */
            -webkit-backdrop-filter: blur(10px);
            /* dukungan Safari */
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- <section class="section d-flex" style="min-height:100vh; align-items: center">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="text-white tw-text-5xl">SIPENDA</h1>
                        <p class="lead text-white tw-text-2xl">Sistem Informasi Pensiun Digital & Arsip</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login.store') }}" class="needs-validation">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="username"
                                            class="form-control @error('username') is-invalid
                                        @enderror"
                                            name="username" value="{{ old('username') }}" tabindex="1" autofocus>
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="{{ route('password.request') }}" class="text-small">
                                                    Forgot
                                                    Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid
                                        @enderror"
                                            name="password" tabindex="2">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        {{-- <section class="section d-flex" style="min-height:100vh; align-items: center">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="text-white tw-text-5xl">SIPENDA</h1>
                        <p class="lead text-white tw-text-2xl">Sistem Informasi Pensiun Digital & Arsip</p>
                    </div>
                </div>

                <div class="row mt-3 align-items-center">
                    <!-- Kolom Form Login -->
                    <div class="col-12 col-md-6 col-lg-5 offset-lg-1">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login.store') }}" class="needs-validation">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') }}" tabindex="1" autofocus>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="{{ route('password.request') }}" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password" tabindex="2">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Gambar -->
                    <div class="col-12 col-md-6 col-lg-5 text-center">
                        <img src="{{ asset('assets/img/slider-dec.png') }}" alt="logo" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="section d-flex position-relative" style="min-height:100vh; align-items: center">
            <div class="container">
                <!-- Gambar di kanan form -->
                <div
                    style="
                    position: absolute;
                    right: 15%;
                    top: 50%;
                    transform: translateY(-50%);
                    z-index: 0;
                ">
                    <img src="{{ asset('assets/img/slider-dec.png') }}" alt="logo" width="400">
                </div>

                <!-- Judul -->
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="text-white tw-text-5xl">SIPENDA</h1>
                        <p class="lead text-white tw-text-2xl">Sistem Informasi Pensiun Digital & Arsip</p>
                    </div>
                </div>

                <!-- Form login -->
                <div class="row justify-content-center mt-3" style="z-index: 1; position: relative;">
                    <div class="col-12 col-sm-8 col-md-8 col-lg-4">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login.store') }}" class="needs-validation">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="username"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" tabindex="1" autofocus>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="{{ route('password.request') }}" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            tabindex="2">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Page Specific JS File -->
</body>

</html>
