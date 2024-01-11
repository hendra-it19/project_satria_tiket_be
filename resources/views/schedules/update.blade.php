@extends('layouts.base')

@section('pages')
    <div class="row">
        <div class="col-12 my-3">
            <p><a href="{{ route('schedules.index') }}">Jadwal > </a> Ubah Data</p>
            <h3 class="text-primary">Ubah Data Jadwal</h3>
        </div>

        <div class="col-12">
            <form action="{{ route('schedules.update', $schedule->id) }}" method="post" class="row">
                @csrf
                @method('put')

                <div class="mb-3 col-12 col-md-5">
                    <label for="hari_keberangkatan" class="form-label">Hari Keberangkatan</label>
                    <select name="hari_keberangkatan" id="hari_keberangkatan"
                        class="form-select @error('hari_keberangkatan')
                        is-invalid
                    @enderror">
                        <option value="">Pilih Hari</option>
                        @foreach ($hari as $row => $value)
                            <option value="{{ $value }}" @if (old('hari_keberangkatan', $schedule->hari_keberangkatan) == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('hari_keberangkatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="jam_keberangkatan" class="form-label">Jam Keberangkatan</label>
                    <input type="time" id="jam_keberangkatan" name="jam_keberangkatan"
                        class="form-control @error('jam_keberangkatan')
                        is-invalid
                    @enderror"
                        value="{{ old('jam_keberangkatan', $schedule->jam_keberangkatan) }}">
                    @error('jam_keberangkatan')
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
                            <option value="{{ $value }}" @if (old('tujuan', $schedule->tujuan) == $value) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('tujuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('schedules.index') }}" class="btn btn-outline-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
