<?php

namespace App\Http\Controllers;

use App\Models\KursiPenumpang;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $judulHalaman = 'Transaksi';

    public function index()
    {
        $judulHalaman = $this->judulHalaman;
        $data = Transaction::with('ticket')->orderBy('id', 'DESC')->get();
        $no = 1;
        return view('transactions.index', compact('data', 'judulHalaman', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $judulHalaman = $this->judulHalaman;
        $kursi = $transaction->kursi;
        $penumpang = $transaction->penumpang;
        return view('transactions.show', compact('judulHalaman', 'transaction', 'kursi', 'penumpang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update([
            'selesai',
        ]);
        return redirect()->route('transactions.index')
            ->with('success', 'Tiket telah di klaim!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')
            ->with('success', 'Data Transaksi berhasil dihapus!');
    }

    public function claim($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'status' => 'selesai'
        ]);
        return redirect()->route('transactions.index')
            ->with('success', 'Berhasil melakukan klaim tiket!');
    }

    public function bayar($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'status' => 'proses',
        ]);
        return redirect()->route('transactions.index')
            ->with('success', 'Berhasil melakukan konfirmasi pembayaran offline!');
    }
}
