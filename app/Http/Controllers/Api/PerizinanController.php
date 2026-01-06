<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PerizinanController extends Controller
{
    /**
     * User mengajukan perizinan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis'            => ['required', Rule::in(['IZIN', 'CUTI', 'SAKIT'])],
            'tanggal_mulai'    => ['required', 'date'],
            'tanggal_selesai'  => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'keterangan'       => ['nullable', 'string'],
            'lampiran'         => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')
                ->store('lampiran_perizinan', 'public');
        }

        $validated['user_id'] = $request->user()->id;

        $validated['status'] = 'PENDING';

        $perizinan = Perizinan::create($validated);

        return response()->json([
            'message' => 'Pengajuan perizinan berhasil dikirim',
            'data'    => $perizinan,
        ], 201);
    }
}
