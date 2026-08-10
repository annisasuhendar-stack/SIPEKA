<?php

namespace App\Http\Controllers;

use App\Models\InseminasiBuatan;
use Illuminate\Http\Request;
use App\Exports\InseminasiBuatanExport
class InseminasiBuatanController extends Controller
{
    public function index()
    {
        $data = InseminasiBuatan::latest()->get();

        return view('inseminasi.index', compact('data'));
    }

    public function create()
    {
        return view('inseminasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_hewan' => 'required',
            'identitas_pemilik' => 'required',
            'alamat' => 'required',
        ]);

        InseminasiBuatan::create([
            'jenis_hewan' => $request->jenis_hewan,
            'identitas_pemilik' => $request->identitas_pemilik,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('inseminasi.index')
            ->with('success', 'Data inseminasi buatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = InseminasiBuatan::findOrFail($id);

        return view('inseminasi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_hewan' => 'required',
            'identitas_pemilik' => 'required',
            'alamat' => 'required',
        ]);

        $data = InseminasiBuatan::findOrFail($id);

        $data->update([
            'jenis_hewan' => $request->jenis_hewan,
            'identitas_pemilik' => $request->identitas_pemilik,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('inseminasi.index')
            ->with('success', 'Data inseminasi buatan berhasil diperbarui!');
    }
    public function export()
{
    return Excel::download(new InseminasiBuatanExport, 'data-inseminasi-buatan.xlsx');
}
    public function destroy($id)
    {
        $data = InseminasiBuatan::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('inseminasi.index')
            ->with('success', 'Data inseminasi buatan berhasil dihapus!');
    }
}