@extends('layouts.base')

@section('pages')
    <div class="row">
        <div class="col-12 my-3">
            <p><a href="{{ route('tickets.index') }}">Tiket > </a> Tambah Data</p>
            <h3 class="text-primary">Tambah Daftar Tiket</h3>
        </div>

        <div class="col-12">
            <form action="{{ route('tickets.store') }}" method="post" class="row">
                @csrf
                @method('post')

                <div class="mb-3 col-12 col-md-5">
                    <label for="kapal" class="form-label">Kapal</label>
                    <select name="kapal" id="kapal"
                        class="form-select @error('kapal')
                        is-invalid
                    @enderror">
                        <option value="">Pilih Kapal</option>
                        @foreach ($kapal as $row)
                            <option value="{{ $row->id }}" @if (old('kapal') == $row->id) selected @endif>
                                {{ $row->nama_kapal }}
                            </option>
                        @endforeach
                    </select>
                    @error('kapal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="harga" class="form-label">Harga Tiket</label>
                    <input type="number" id="harga" name="harga" min="0"
                        class="form-control @error('harga')
                        is-invalid
                    @enderror"
                        value="{{ old('harga') }}">
                    @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="stok" class="form-label">stok Tiket</label>
                    <input type="number" id="stok" name="stok" min="0"
                        class="form-control @error('stok')
                        is-invalid
                    @enderror"
                        value="{{ old('stok', $jumlahKursi) }}">
                    @error('stok')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="tujuan" class="form-label">Tujuan Perjalanan</label>
                    <select name="tujuan" id="tujuan"
                        class="form-select @error('tujuan')
                        is-invalid
                    @enderror">
                        <option value="">Pilih tujuan</option>
                        @foreach ($tujuan as $row => $value)
                            <option value="{{ $value }}" @if (old('tujuan') == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('tujuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="keberangkatan" class="form-label">Waktu Keberangkatan</label>
                    <input type="datetime-local" id="keberangkatan" name="keberangkatan"
                        class="form-control @error('keberangkatan')
                        is-invalid
                    @enderror"
                        value="{{ old('keberangkatan') }}">
                    @error('keberangkatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
