@extends('layouts.base')

@section('pages')
    <div class="row">

        <div class="col-12 d-flex justify-content-between align-items-center my-5 ">
            <h3 class="text-primary">Daftar Kapal</h3>
            <a href="{{ route('ships.create') }}" class="btn btn-outline-primary">Tambah Data Kapal</a>
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
                    <th>Nama Kapal</th>
                    <th>Tahun Produksi</th>
                    <th>Kapasitas</th>
                    <th>Lebar </th>
                    <th>Panjang </th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->nama_kapal }}</td>
                            <td>{{ $row->tahun_produksi }}</td>
                            <td>{{ $row->kapasitas_penumpang }}</td>
                            <td>{{ $row->lebar_kapal }} meter</td>
                            <td>{{ $row->panjang_kapal }} meter</td>
                            <td>
                                {{-- <a href="{{ route('ships.show', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-eye text-primary"></i>
                                </a> --}}
                                <a href="{{ route('ships.edit', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-pen text-warning"></i>
                                </a>
                                <form action="{{ route('ships.destroy', $row->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm d-inline"
                                        onclick="return confirm('Yakin ingin menghapus data kapal {{ $row->nama_kapal }}?')">
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
