@extends('layouts.base')

@section('pages')
    <div class="row rounded py-4">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Jumlah User</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $user }}</h6>
                    <a href="{{ route('users.index') }}" class="card-link">Detail...</a>

                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Transaksi</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $transaksi }}</h6>
                    <a href="{{ route('transactions.index') }}" class="card-link">Detail...</a>

                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Tiket</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $tiket }}</h6>
                    <a href="{{ route('tickets.index') }}" class="card-link">Detail...</a>

                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Kapal</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $tiket }}</h6>
                    <a href="#" class="card-link">Detail...</a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-light rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Kalender</h6>
                </div>
                <div id="calender"></div>
            </div>
        </div>
    </div>
@endsection
