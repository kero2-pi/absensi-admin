<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;

class SettingsController extends Controller
{
    public function index()
    {
        //$holidays = Holiday::orderBy('tanggal')->get();
        $shifts   = Shift::orderBy('nama_shift')->get();

        return view('settings.index', compact( 'shifts'));
        //'holidays'
    }

    public function shifts()
    {
        $shifts = Shift::orderBy('nama_shift')->get();
        return view('settings.shifts', compact('shifts'));
    }

}
