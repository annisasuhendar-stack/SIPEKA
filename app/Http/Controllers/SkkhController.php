<?php

namespace App\Http\Controllers;

use App\Models\Skkh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkkhController extends Controller
{
    public function index()
    {
        $skkhs = Skkh::latest()->paginate(10);

        return view('skkh.index', compact('skkhs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'       => 'nullable|string|max:255',
            'nama_pemilik'      => 'required|string|max:255',
            'identitas_pemilik' => 'nullable|string',
            'jenis_hewan'       => 'required|string|max:255',
            'tujuan_pengiriman' => 'nullable|string|max:255',
            'dokumen'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->except('dokumen');

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')
                ->store('dokumen-skkh', 'public');
        }

        Skkh::create($data);

        return redirect()
            ->route('skkh.index')
            ->with('success', 'Data SKKH berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat'       => 'nullable|string|max:255',
            'nama_pemilik'      => 'required|string|max:255',
            'identitas_pemilik' => 'nullable|string',
            'jenis_hewan'       => 'required|string|max:255',
            'tujuan_pengiriman' => 'nullable|string|max:255',
            'dokumen'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $skkh = Skkh::findOrFail($id);

        $data = $request->except('dokumen');

        if ($request->hasFile('dokumen')) {

            if ($skkh->dokumen) {
                Storage::disk('public')->delete($skkh->dokumen);
            }

            $data['dokumen'] = $request->file('dokumen')
                ->store('dokumen-skkh', 'public');
        }

        $skkh->update($data);

        return redirect()
            ->route('skkh.index')
            ->with('success', 'Data SKKH berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $skkh = Skkh::findOrFail($id);

        if ($skkh->dokumen) {
            Storage::disk('public')->delete($skkh->dokumen);
        }

        $skkh->delete();

        return redirect()
            ->route('skkh.index')
            ->with('success', 'Data SKKH berhasil dihapus!');
    }
}