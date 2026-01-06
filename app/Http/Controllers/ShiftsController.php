<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftsController extends Controller
{
    public function index()
    {
        $shifts = Shift::orderBy('nama_shift')->get();
        return view('settings.shifts', compact('shifts'));
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'nama_shift' => 'required|string',
            'mulai' => 'required',
            'selesai' => 'required|after:mulai'
        ]);

        $shift->update($request->only('nama_shift', 'mulai', 'selesai'));

        return back()->with('success', 'Shift berhasil diperbarui');
    }
}
