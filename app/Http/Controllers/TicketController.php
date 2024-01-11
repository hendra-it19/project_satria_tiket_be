<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $judulHalaman = 'Tiket';
    private $tujuan = [
        'wanci-lasalimu',
        'lasalimu-wanci',
    ];

    public function index()
    {
        $judulHalaman = $this->judulHalaman;
        $data = Ticket::orderBy('id', 'DESC')->get();
        $no = 1;
        return view('tickets.index', compact('data', 'judulHalaman', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $judulHalaman = $this->judulHalaman;
        $kapal = Ship::all();
        $tujuan = $this->tujuan;
        return view('tickets.create', compact('judulHalaman', 'kapal', 'tujuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kapal' => ['required', 'exists:ships,id'],
            'stok' => ['required', 'min:0', 'numeric'],
            'harga' => ['required'],
            'tujuan' => ['required', 'in:lasalimu-wanci,wanci-lasalimu'],
            'keberangkatan' => ['required'],
        ]);
        Ticket::create([
            'ship_id' => $request->kapal,
            'sisa_stok' => $request->stok,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'tujuan' => $request->tujuan,
            'keberangkatan' => $request->keberangkatan,
        ]);
        return redirect()->route('tickets.index')
            ->with('success', 'Data tiket berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $judulHalaman = $this->judulHalaman;
        $transactions = Transaction::where('ticket_id', $ticket->id)->OrderBy('id', 'DESC')->get();
        return view('tickets.show', compact('judulHalaman', 'transactions', 'ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $judulHalaman = $this->judulHalaman;
        $tujuan = $this->tujuan;
        $kapal = Ship::all();
        return view('tickets.update', compact('judulHalaman', 'tujuan', 'ticket', 'kapal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'kapal' => ['required', 'exists:ships,id'],
            'stok' => ['required', 'min:0', 'numeric'],
            'harga' => ['required'],
            'tujuan' => ['required', 'in:lasalimu-wanci,wanci-lasalimu'],
            'keberangkatan' => ['required'],
        ]);
        $ticket->update([
            'ship_id' => $request->kapal,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'tujuan' => $request->tujuan,
            'keberangkatan' => $request->keberangkatan,
        ]);
        return redirect()->route('tickets.index')
            ->with('success', 'Data tiket berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $transactions = Transaction::where('ticket_id', $ticket->id)->first();
        if (empty($transactions)) {
            $ticket->delete();
            return redirect()->back()
                ->with('success', 'Data tiket berhasil dihapus!');
        }
        return redirect()->back()
            ->with('error', 'Data tiket masih digunakan dalam transaksi!');
    }
}
