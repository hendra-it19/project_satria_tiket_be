@extends('layouts.base')

@section('pages')
    <div class="row">

        <div class="col-12 d-flex justify-content-between align-items-center my-5 ">
            <h3 class="text-primary">Daftar Jadwal</h3>
            <a href="{{ route('schedules.create') }}" class="btn btn-outline-primary">Tambah Jadwal Kapal</a>
        </div>



        <div class="col-12 rounded">

            @session('success')
                <div class="alert alert-primary">
                    {{ Session::get('success') }}
                </div>
            @endsession

            @session('error')
                <div class="alert alert-warning">
                    {{ Session::get('error') }}
                </div>
            @endsession

            <table class="table" id="table" data-page-length='10'>
                <thead>
                    <th>No</th>
                    <th>Hari Keberangkatan</th>
                    <th>Jam keberangkatan</th>
                    <th>Tujuan</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->hari_keberangkatan }}</td>
                            <td>{{ $row->jam_keberangkatan }}</td>
                            <td>{{ $row->tujuan }}</td>
                            <td>
                                {{-- <a href="{{ route('schedules.show', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-eye text-primary"></i>
                                </a> --}}
                                <a href="{{ route('schedules.edit', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-pen text-warning"></i>
                                </a>
                                <form action="{{ route('schedules.destroy', $row->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm d-inline"
                                        onclick="return confirm('Yakin ingin menghapus data jadwal kapal?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
