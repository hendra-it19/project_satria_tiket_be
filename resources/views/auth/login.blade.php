@extends('auth.layouts')

@section('pages')
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-white rounded shadow-sm p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-3">
                        <img src="{{ asset('logo.png') }}" alt="logo" width="70px">
                        <h3>
                            <span>Satria</span><span class="text-primary">Tiket</span>
                        </h3>
                    </div>

                    <p>Masukkan email dan password anda !</p>

                    @if ($message = Session::get('error_login'))
                        <div class="alert py-2 alert-danger my-4">
                            {{ $message }}
                        </div>
                    @endif
                    @if ($message = Session::get('success_register'))
                        <div class="alert py-2 alert-primary my-4">
                            {{ $message }}
                        </div>
                    @endif

                    <form action="{{ route('loginPost') }}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email"
                                class="form-control @error('email')
                                is-invalid
                            @enderror"
                                id="email" placeholder="name@example.com" name="email" value="{{ old('email') }}">
                            <label for="email">Alamat Email</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password"
                                class="form-control @error('password')
                                is-invalid
                            @enderror"
                                id="password" placeholder="Password" name="password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="ingat_saya" name="ingat_saya"
                                    value="1">
                                <label class="form-check-label" for="ingat_saya">Ingat Saya</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary py-2 w-100 mb-4">Masuk</button>
                    </form>
                    @if ($is_register)
                        <p class="text-center mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
