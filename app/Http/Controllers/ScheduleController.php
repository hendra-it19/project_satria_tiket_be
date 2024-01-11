<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $judulHalaman = 'Jadwal';
    private $hari =  [
        'senin',
        'selasa',
        'rabu',
        'kamis',
        'jumat',
        'sabtu',
        'minggu'
    ];
    private $tujuan = [
        'wanci-lasalimu',
        'lasalimu-wanci',
    ];


    public function index(): View
    {
        $judulHalaman = $this->judulHalaman;
        $data = Schedule::orderBy('id', 'DESC')->get();
        $no = 1;
        return view('schedules.index', compact('data', 'judulHalaman', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hari = $this->hari;
        $judulHalaman = $this->judulHalaman;
        $tujuan = $this->tujuan;

        return view('schedules.create', compact('hari', 'judulHalaman', 'tujuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari_keberangkatan' => ['required', 'in:senin,selasa,rabu,kamis,jumat,sabtu,minggu'],
            'jam_keberangkatan' => ['required'],
            'tujuan' => ['required', 'in:lasalimu-wanci,wanci-lasalimu'],
        ]);
        Schedule::create([
            'hari_keberangkatan' => $request->hari_keberangkatan,
            'jam_keberangkatan' => $request->jam_keberangkatan,
            'tujuan' => $request->tujuan,
        ]);
        return redirect()->route('schedules.index')
            ->with('success', 'Data jadwal kapal berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $judulHalaman = $this->judulHalaman;
        $hari = $this->hari;
        $tujuan = $this->tujuan;
        return view('schedules.update', compact('judulHalaman', 'hari', 'tujuan', 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'hari_keberangkatan' => ['required', 'in:senin,selasa,rabu,kamis,jumat,sabtu,minggu'],
            'jam_keberangkatan' => ['required'],
            'tujuan' => ['required', 'in:lasalimu-wanci,wanci-lasalimu'],
        ]);
        $schedule->update([
            'hari_keberangkatan' => $request->hari_keberangkatan,
            'jam_keberangkatan' => $request->jam_keberangkatan,
            'tujuan' => $request->tujuan,
        ]);
        return redirect()->route('schedules.index')
            ->with('success', 'Data jadwal kapal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()
            ->with('success', 'Data jadwal kapal berhasil dihapus!');
    }
}
