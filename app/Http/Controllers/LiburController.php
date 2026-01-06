<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libur;

class LiburController extends Controller
{
    public function manage($id = null)
    {
        $libur = Libur::orderBy('tanggal', 'asc')->get();
        $editLibur = $id ? Libur::findOrFail($id) : null;

        return view('settings.libur', compact('libur', 'editLibur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:libur,tanggal',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Libur::create($request->all());

        return redirect()->route('libur.manage')->with('success', 'Data libur berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $libur = Libur::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date|unique:libur,tanggal,'.$id,
            'keterangan' => 'nullable|string|max:255',
        ]);

        $libur->update($request->all());

        return redirect()->route('libur.manage')->with('success', 'Data libur berhasil diupdate!');
    }

    public function destroy($id)
    {
        $libur = Libur::findOrFail($id);
        $libur->delete();

        return redirect()->route('libur.manage')->with('success', 'Data libur berhasil dihapus!');
    }
}
