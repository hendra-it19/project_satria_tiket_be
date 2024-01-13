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

                    <p>Lengkapi data anda untuk mendaftar!</p>

                    <form action="{{ route('registerPost') }}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control @error('nama')
                                is-invalid
                            @enderror"
                                id="nama" placeholder="Indriani Hasim" name="nama" value="{{ old('nama') }}">
                            <label for="nama">Nama Lengkap</label>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
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
                        <div class="form-floating mb-4">
                            <input type="password"
                                class="form-control @error('konfirmasi_password')
                                is-invalid
                            @enderror"
                                id="konfirmasi_password" placeholder="konfirmasi password" name="konfirmasi_password">
                            <label for="konfirmasi_password">Konfirmasi password</label>
                            @error('konfirmasi_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <input type="hidden" name="role" value="admin">


                        <button type="submit" class="btn btn-primary py-2 w-100 mb-4 mt-3">Daftar</button>
                    </form>
                    <p class="text-center mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
