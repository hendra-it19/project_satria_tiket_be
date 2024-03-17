@extends('layouts.base')

@section('pages')
    @inject('carbon', 'Carbon\Carbon')
    @php
        $start = $carbon::parse($ticket->created_at);
        $end = $carbon::parse($ticket->keberangkatan);
        $check = $carbon::now()->between($start, $end, true);
    @endphp

    <div class="row">

        <div class="col-12 my-3">
            <p><a href="{{ route('tickets.index') }}">Tiket > </a> Tambah Data</p>
            <h3 class="text-primary">Detail Tiket dan Transaksi</h3>
        </div>


        <div class="col-12 mb-4">
            <table>
                <tbody>
                    <tr>
                        <td>Nama Kapal</td>
                        <td>: {{ $ticket->ship->nama_kapal }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Stok</td>
                        <td>: {{ $ticket->stok }}</td>
                    </tr>
                    <tr>
                        <td>Sisa Stok</td>
                        <td>: {{ $ticket->sisa_stok }}</td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>: Rp. {{ $ticket->harga }}</td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>: {{ $ticket->tujuan }}</td>
                    </tr>
                    <tr>
                        <td>Waktu keberangkatan</td>
                        <td>: {{ $carbon::parse($ticket->keberangkatan)->diffForHumans() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>



        <div class="col-12 rounded">

            <table class="table" id="table">
                <thead>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Email</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    @foreach ($transactions as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->user->nama }}</td>
                            <td>{{ $row->user->email }}</td>
                            <td>{{ $row->jumlah }}</td>
                            <td>{{ $row->total_harga }}</td>
                            <td>{{ $row->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-danger">Kembali</a>
            </div>
        </div>
    </div>
@endsection
