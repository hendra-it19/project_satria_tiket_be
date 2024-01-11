@extends('layouts.base')

@section('pages')
    <div class="row">
        <div class="col-12 my-3">
            <p><a href="{{ route('ships.index') }}">Kapal > </a> Tambah Data</p>
            <h3 class="text-primary">Tambah Daftar Kapal</h3>
        </div>

        <div class="col-12">
            <form action="{{ route('ships.store') }}" method="post" class="row">
                @csrf
                @method('post')

                <div class="mb-3 col-12 col-md-5">
                    <label for="nama_kapal" class="form-label">Nama Kapal</label>
                    <input type="text" id="nama_kapal" name="nama_kapal"
                        class="form-control @error('nama_kapal')
                        is-invalid
                    @enderror"
                        value="{{ old('nama_kapal') }}">
                    @error('nama_kapal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="kapasitas_penumpang" class="form-label">Kapasitas Penumpang</label>
                    <input type="number" id="kapasitas_penumpang" name="kapasitas_penumpang"
                        class="form-control @error('kapasitas_penumpang')
                        is-invalid
                    @enderror"
                        value="{{ old('kapasitas_penumpang') }}">
                    @error('kapasitas_penumpang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="panjang_kapal" class="form-label">Panjang Kapal (m)</label>
                    <input type="number" id="panjang_kapal" name="panjang_kapal"
                        class="form-control @error('panjang_kapal')
                        is-invalid
                    @enderror"
                        value="{{ old('panjang_kapal') }}">
                    @error('panjang_kapal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="lebar_kapal" class="form-label">Lebar Kapal (m)</label>
                    <input type="number" id="lebar_kapal" name="lebar_kapal"
                        class="form-control @error('lebar_kapal')
                        is-invalid
                    @enderror"
                        value="{{ old('lebar_kapal') }}">
                    @error('lebar_kapal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="tahun_produksi" class="form-label">Tahun Produksi</label>
                    <input type="number" id="tahun_produksi" name="tahun_produksi"
                        class="form-control @error('tahun_produksi')
                        is-invalid
                    @enderror"
                        value="{{ old('tahun_produksi') }}">
                    @error('tahun_produksi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('ships.index') }}" class="btn btn-outline-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
