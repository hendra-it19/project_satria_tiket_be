@extends('layouts.base')

@section('pages')
    @inject('carbon', 'Carbon\Carbon')
    @inject('number', 'Illuminate\Support\Number')
    <div class="row">

        <div class="col-12 justify-content-between align-items-center mt-5 mb-3">
            <h3 class="text-primary">Detail Transaksi</h3>
            <p><a href="{{ route('transactions.index') }}">Transaksi</a> / Detail</p>
        </div>


        <div class="col-12 rounded">
            <div class="mb-3">
                <table>
                    <tr>
                        <td>Nama </td>
                        <td>: {{ $transaction->user->title }}, {{ $transaction->user->nama }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $transaction->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $transaction->user->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td>: {{ $transaction->metode_pembayaran }} | {{ $transaction->qr_url }} |
                            {{ $carbon::parse($transaction->expired)->diffForHumans() }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Kursi</td>
                        <td>:
                            @foreach ($kursi as $row)
                                | {{ $row->nomor_kursi }} |
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Penumpang</td>
                        <td>:
                            @foreach ($penumpang as $row)
                                | {{ $row->title }}.{{ $row->nama }}({{ $row->usia }}) |
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
            <h4>Transaksi</h4>
            <table class="table" data-page-length='10'>
                <thead>
                    <th>ID Transaksi</th>
                    <th>Tujuan</th>
                    <th>Waktu Keberangkatan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->ticket->tujuan }}</td>
                        <td>{{ $transaction->ticket->keberangkatan }}</td>
                        <td>{{ $number->currency($transaction->harga, 'IDR', 'ID') }}</td>
                        <td>{{ $transaction->jumlah }}</td>
                        <td>{{ $number->currency($transaction->total_harga, 'IDR', 'ID') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
