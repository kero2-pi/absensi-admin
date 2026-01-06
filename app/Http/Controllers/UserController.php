<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    // search user
    public function search(Request $request)
    {
        $q = $request->q;

        $users = User::with('shift')
        ->where(function ($query) use ($q) {
            $query->where('id', $q)
              ->orWhere('name', 'like', "%{$q}%")
              ->orWhere('email', 'like', "%{$q}%");
            })
        ->orderBy('id', 'desc')
        ->get();


        return view('users.table_rows', compact('users'));
    }


    // Tampilkan form tambah user
    public function create()
    {
        $instansi = Instansi::all();
        $shift = Shift::all();

        return view('users.create', [
            'instansi' => $instansi,
            'shift' => $shift,
        ]);
    }

    // Simpan user baru
    public function store(Request $request)
{
    $request->validate([
        'name'       => 'required',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required',
        'status'     => 'nullable|in:PKL,KARYAWAN',
        'mode_kerja' => 'required|in:WFO,WFH',
        'shift_id'   => 'nullable|exists:shift,id',
    ]);

    if ($request->status === 'KARYAWAN') {
        $request->merge(['instansi' => null]);
    }

    if ($request->mode_kerja === 'WFH') {

        $shiftId = Shift::where('nama_shift', 'FULLTIME')
            ->value('id');

    } else {

        // WFO → WAJIB pilih shift
        if (!$request->shift_id) {
            return back()
                ->withErrors(['shift_id' => 'Shift wajib dipilih untuk WFO'])
                ->withInput();
        }

        $shiftId = $request->shift_id;
    }

    User::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'instansi'   => $request->instansi,
        'status'     => $request->status,
        'mode_kerja' => $request->mode_kerja,
        'shift_id'   => $shiftId, // ✅ DIJAMIN ADA
    ]);

    return redirect()->route('users.index')
    ->with('success', 'User berhasil ditambahkan');

}


}
