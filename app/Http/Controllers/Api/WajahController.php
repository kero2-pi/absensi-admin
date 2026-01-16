<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wajah;

class WajahController extends Controller
{
    /**
     * Simpan data wajah user login
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'data' => ['required', 'array'],
    ]);

    Wajah::updateOrCreate(
        ['user_id' => $request->user()->id],
        ['data' => json_encode($validated['data'])]
    );

    return response()->json([
        'message' => 'Data wajah berhasil disimpan'
    ]);
}


    /**
     * Hapus data wajah user login
     */
    
    public function check(Request $request) 
    {
        $user = $request->user();

        $exists = Wajah::where('user_id', $user->id)->exists();

        return response()->json([
        'has_wajah' => $exists,
        ]);
    }
    
}
