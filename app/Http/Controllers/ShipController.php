<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Ship;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $judulHalaman = "Kapal";
        $data = Ship::orderBy('id', 'DESC')->get();
        $no = 1;
        return view('ships.index', compact('judulHalaman', 'data', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $judulHalaman = "Kapal";
        return view('ships.create', compact('judulHalaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kapal' => ['required', 'unique:ships,nama_kapal,except,id'],
            'kapasitas_penumpang' => ['required', 'numeric'],
            'panjang_kapal' => ['required', 'numeric'],
            'lebar_kapal' => ['required', 'numeric'],
            'tahun_produksi' => ['required', 'digits:4'],
        ]);

        Ship::create([
            'nama_kapal' => $request->nama_kapal,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'panjang_kapal' => $request->panjang_kapal,
            'lebar_kapal' => $request->lebar_kapal,
            'tahun_produksi' => $request->tahun_produksi,
        ]);

        return redirect()->route('ships.index')
            ->with('success', 'Data kapal berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ship $ship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ship $ship)
    {
        $judulHalaman = 'Kapal';
        return view('ships.update', compact('ship', 'judulHalaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ship $ship)
    {
        $request->validate([
            'nama_kapal' => ['required', $request->nama_kapal == $ship->nama_kapal ? '' : 'unique:ships,nama_kapal,except,id'],
            'kapasitas_penumpang' => ['required', 'numeric'],
            'panjang_kapal' => ['required', 'numeric'],
            'lebar_kapal' => ['required', 'numeric'],
            'tahun_produksi' => ['required', 'digits:4'],
        ]);

        $ship->update([
            'nama_kapal' => $request->nama_kapal,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'panjang_kapal' => $request->panjang_kapal,
            'lebar_kapal' => $request->lebar_kapal,
            'tahun_produksi' => $request->tahun_produksi,
        ]);

        return redirect()->route('ships.index')
            ->with('success', 'Data kapal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ship $ship)
    {
        $tickets = Ticket::where('ship_id', $ship->id)->first();
        $schedule = Schedule::where('ship_id', $ship->id)->first();
        if (empty($tickets) && empty($schedule)) {
            $ship->delete();
            return redirect()->back()
                ->with('success', 'Data kapal berhasil dihapus!');
        }
        return redirect()->back()
            ->with('error', 'Data kapal sedang digunakan!');
    }
}
