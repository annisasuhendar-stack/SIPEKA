<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SuratKeteranganUsahaController extends Controller
{
    public function index()
    {
        $suratKeteranganUsahas = SuratKeteranganUsaha::latest()
            ->paginate(10);

        return view('surat_keterangan_usaha.index', compact('suratKeteranganUsahas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'          => 'nullable|string|max:255',
            'identitas_pemilik'    => 'nullable|string',
            'jenis_komoditi_usaha' => 'required|string|max:255',
            'dokumen'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->except('dokumen');

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'dokumen-sku/' . $filename;

            $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
            $supabaseKey = env('SUPABASE_KEY');
            $bucket = env('SUPABASE_BUCKET');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseKey,
                'apikey' => $supabaseKey,
                'Content-Type' => $file->getMimeType(),
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getMimeType()
            )->post(
                $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $path
            );

            if (!$response->successful()) {
                return back()
                    ->withInput()
                    ->with('error', 'Upload dokumen gagal: ' . $response->body());
            }

            $data['dokumen'] = $path;
        }

        SuratKeteranganUsaha::create($data);

        return redirect()
            ->route('surat-keterangan-usaha.index')
            ->with('success', 'Surat Keterangan Usaha berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat'          => 'nullable|string|max:255',
            'identitas_pemilik'    => 'nullable|string',
            'jenis_komoditi_usaha' => 'required|string|max:255',
            'dokumen'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $surat = SuratKeteranganUsaha::findOrFail($id);

        $data = $request->except('dokumen');

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'dokumen-sku/' . $filename;

            $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
            $supabaseKey = env('SUPABASE_KEY');
            $bucket = env('SUPABASE_BUCKET');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseKey,
                'apikey' => $supabaseKey,
                'Content-Type' => $file->getMimeType(),
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getMimeType()
            )->post(
                $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $path
            );

            if (!$response->successful()) {
                return back()
                    ->withInput()
                    ->with('error', 'Upload dokumen gagal: ' . $response->body());
            }

            $data['dokumen'] = $path;
        }

        $surat->update($data);

        return redirect()
            ->route('surat-keterangan-usaha.index')
            ->with('success', 'Surat Keterangan Usaha berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = SuratKeteranganUsaha::findOrFail($id);

        $surat->delete();

        return redirect()
            ->route('surat-keterangan-usaha.index')
            ->with('success', 'Surat Keterangan Usaha berhasil dihapus!');
    }
}