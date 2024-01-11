@extends('layouts.base')

@section('pages')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">

        <div class="col-12 d-flex justify-content-between align-items-center my-5">
            <h3 class="text-primary">Daftar Tiket</h3>
            <a href="{{ route('tickets.create') }}" class="btn btn-outline-primary">Tambah Tiket Kapal</a>
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
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Sisa Stok</th>
                    <th>Tujuan</th>
                    <th>Keberangkatan</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->ship->nama_kapal }}</td>
                            <td>{{ $row->harga }}</td>
                            <td>{{ $row->stok }}</td>
                            <td>{{ $row->sisa_stok }}</td>
                            <td>{{ $row->tujuan }}</td>
                            <td>
                                {{ $carbon::parse($row->keberangkatan)->diffForHumans() }}
                                |
                                {{-- {{ $carbon::parse($row->keberangkatan)->diffInHours() }}</td> --}}
                                @php
                                    $start = $carbon::parse($row->created_at);
                                    $end = $carbon::parse($row->keberangkatan);
                                    $check = $carbon::now()->between($start, $end, true);
                                @endphp
                                @if ($check)
                                    <span class="alert p-1 alert-primary">Masih berlaku</span>
                                @else
                                    <span class="alert p-1 alert-danger">Tidak berlaku</span>
                                @endif
                            <td>
                                <a href="{{ route('tickets.show', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                                <a href="{{ route('tickets.edit', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-pen text-warning"></i>
                                </a>
                                <form action="{{ route('tickets.destroy', $row->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm d-inline"
                                        onclick="return confirm('Yakin ingin menghapus data tiket?')">
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
