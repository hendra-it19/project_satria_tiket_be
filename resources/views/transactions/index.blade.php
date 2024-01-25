@extends('layouts.base')

@section('pages')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">

        <div class="col-12 d-flex justify-content-between align-items-center my-5">
            <h3 class="text-primary">Daftar Transaksi</h3>
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
                    <th>Keberangkatan</th>
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
                            <td>{{ $carbon::parse($row->ticket->keberangkatan)->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $row->id) }}" class="btn btn-sm d-block">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                                {{-- <a href="{{ route('transactions.edit', $row->id) }}" class="btn btn-sm d-inline">
                                    <i class="fas fa-pen text-warning"></i>
                                </a> --}}

                                @if ($row->status == 'pending' && $carbon::now() < $carbon::parse($row->ticket->keberangkatan))
                                    <form action="{{ route('transactions.bayar', $row->id) }}" method="post"
                                        class="d-block">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-sm d-block btn-primary"
                                            onclick="return confirm('Yakin ingin konfirmasi pembayaran langsung?')">
                                            Bayar
                                        </button>
                                    </form>
                                @elseif ($row->status == 'pending' && $carbon::now() >= $carbon::parse($row->ticket->keberangkatan))
                                    <button class="btn btn-sm d-block btn-danger" disabled>
                                        Bayar
                                    </button>
                                @elseif ($row->status == 'proses' && $carbon::now() < $carbon::parse($row->ticket->keberangkatan))
                                    <form action="{{ route('transactions.claim', $row->id) }}" method="post"
                                        class="d-block">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-sm d-block btn-primary"
                                            onclick="return confirm('Yakin ingin melakukan claim tiket?')">
                                            Claim
                                        </button>
                                    </form>
                                @elseif ($row->status == 'proses' && $carbon::now() >= $carbon::parse($row->ticket->keberangkatan))
                                    <button class="btn btn-sm d-block btn-danger" disabled>
                                        Claim
                                    </button>
                                @elseif ($row->status == 'selesai' && $carbon::now() < $carbon::parse($row->ticket->keberangkatan))
                                    <button class="btn btn-sm d-block btn-outline-primaryy" disabled>
                                        Proses
                                    </button>
                                @elseif ($row->status == 'selesai' && $carbon::now() >= $carbon::parse($row->ticket->keberangkatan))
                                    <button class="btn btn-sm d-block btn-outline-primary" disabled>
                                        Berangkat
                                    </button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
