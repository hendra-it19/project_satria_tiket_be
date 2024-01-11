@extends('layouts.base')

@section('pages')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">

        <div class="col-12 d-flex justify-content-between align-items-center my-5">
            <h3 class="text-primary">Daftar Pengguna</h3>
            <a href="{{ route('users.create') }}" class="btn btn-outline-primary">Tambah Akun</a>
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
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Handphone</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->hp }}</td>
                            <td>{{ $row->alamat }}</td>
                            <td>{{ $row->role }}</td>
                            <td>
                                <a href="{{ route('users.show', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                                <a href="{{ route('users.edit', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-pen text-warning"></i>
                                </a>
                                @if ($row->id == 1 && $row->role == 'admin')
                                    <button class="d-inline btn btn-sm" disabled>
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                @else
                                    <form action="{{ route('users.destroy', $row->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm d-inline"
                                            onclick="return confirm('Yakin ingin menghapus data transaksi?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
