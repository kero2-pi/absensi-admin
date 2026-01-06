<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PerizinanApprovalController extends Controller
{
    /**
     * List perizinan PENDING
     */
    public function index()
    {
        $perizinan = Perizinan::with('user')
            ->where('status', 'PENDING')
            ->orderBy('tanggal_mulai')
            ->get();

        return view('perizinan', compact('perizinan'));
    }

    /**
     * Approve perizinan
     */
    

    public function approve(Perizinan $perizinan)
    {
        $perizinan->update([
            'status'       => 'DISETUJUI',
            'approved_by'  => Auth::id(),
            'approved_at'  => now(),
        ]);

        $user  = $perizinan->user;
        $shift = $user->shift;

        $period = CarbonPeriod::create(
            $perizinan->tanggal_mulai,
            $perizinan->tanggal_selesai
        );

        foreach ($period as $date) {
            Kehadiran::updateOrCreate(
                [
                    'user_id' => $perizinan->user_id,
                    'tanggal' => $date->toDateString(),
                ],
                [
                    'status' => $perizinan->jenis,
                    'shift' => $shift->nama_shift,
                    'jam_shift_masuk' => $shift->mulai,
                ]
            );
        }

        return back()->with('success', 'Perizinan disetujui dan kehadiran diperbarui');
    }


    /**
     * Reject perizinan
     */
    public function reject(Request $request, Perizinan $perizinan)
    {
        $request->validate([
            'keterangan' => 'nullable|string'
        ]);

        $perizinan->update([
            'status'       => 'DITOLAK',
            'approved_by'  => Auth::id(),
            'approved_at'  => now(),
            'keterangan'   => $request->keterangan,
        ]);

        return back()->with('success', 'Perizinan ditolak');
    }
}
