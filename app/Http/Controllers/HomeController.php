<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $tanggal = Carbon::today()->toDateString();

        $users = User::with([
            'shift',
            'kehadiran' => function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            },
        ])
        ->orderBy('shift_id')
        ->orderBy('name')
        ->get()
        ->groupBy(fn ($user) => $user->shift->nama_shift ?? 'Tanpa Shift');

        return view('home', compact('tanggal', 'users'));
    }
}
