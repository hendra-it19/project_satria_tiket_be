@extends('layouts.base')

@section('pages')
    <div class="row">
        <div class="col-12 my-3">
            <p><a href="{{ route('users.index') }}">Akun > </a> Tambah Data</p>
            <h3 class="text-primary">Tambah Data Akun</h3>
        </div>

        <div class="col-12">
            <form action="{{ route('users.store') }}" method="post" class="row">
                @csrf
                @method('post')

                <div class="mb-3 col-12 col-md-5">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger"> *</span></label>
                    <input type="text" id="nama" name="nama"
                        class="form-control @error('nama')
                        is-invalid
                    @enderror"
                        value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="email" class="form-label">Email <span class="text-danger"> *</span></label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email')
                        is-invalid
                    @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="hp" class="form-label">No Handphone</label>
                    <input type="number" id="hp" name="hp"
                        class="form-control @error('hp')
                        is-invalid
                    @enderror"
                        value="{{ old('hp') }}">
                    @error('hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" id="alamat" name="alamat"
                        class="form-control @error('alamat')
                        is-invalid
                    @enderror"
                        value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="role" class="form-label">Hak akses (role) <span class="text-danger"> *</span></label>
                    <select name="role" id="role"
                        class="form-select @error('role')
                        is-invalid
                    @enderror">
                        <option value="">Pilih role</option>
                        @foreach ($role as $row => $value)
                            <option value="{{ $value }}" @if (old('role') == $value) selected @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="password" class="form-label">Password <span class="text-danger"> *</span></label>
                    <input type="text" id="password" name="password"
                        class="form-control @error('password')
                        is-invalid
                    @enderror"
                        value="{{ old('password') }}">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password <span class="text-danger"> *</span></label>
                    <input type="text" id="konfirmasi_password" name="konfirmasi_password"
                        class="form-control @error('konfirmasi_password')
                        is-invalid
                    @enderror"
                        value="{{ old('konfirmasi_password') }}">
                    @error('konfirmasi_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="my-4">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
