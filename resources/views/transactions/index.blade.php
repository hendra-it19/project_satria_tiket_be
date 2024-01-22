@extends('layouts.base')

@section('pages')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">

        <div class="col-12 d-flex justify-content-between align-items-center my-5">
            <h3 class="text-primary">Daftar Transaksi</h3>
            {{-- <a href="{{ route('transactions.create') }}" class="btn btn-outline-primary">Tambah Tiket Kapal</a> --}}
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
                    <th>ID Transaksi</th>
                    <th>Nama Pembeli</th>
                    <th>Email</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>status</th>
                    <th>Transaksi terakhir</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->transaction_id }}</td>
                            <td>{{ $row->user->nama }}</td>
                            <td>{{ $row->user->email }}</td>
                            <td>{{ $row->harga }}</td>
                            <td>{{ $row->jumlah }}</td>
                            <td>{{ $row->total_harga }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $carbon::parse($row->updated_at)->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                                {{-- <a href="{{ route('transactions.edit', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-pen text-warning"></i>
                                </a> --}}
                                {{-- <form action="{{ route('transactions.destroy', $row->id) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm d-inline"
                                        onclick="return confirm('Yakin ingin menghapus data transaksi?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
