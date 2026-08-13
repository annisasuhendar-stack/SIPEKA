<?php

namespace App\Http\Controllers;

use App\Models\Skkh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SkkhController extends Controller
{
    private function uploadToSupabase($file)
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $url = rtrim(env('SUPABASE_URL'), '/')
            . '/storage/v1/object/'
            . env('SUPABASE_BUCKET')
            . '/'
            . $fileName;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_KEY'),
            'apikey'        => env('SUPABASE_KEY'),
            'Content-Type'  => $file->getMimeType(),
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post($url);

        if (!$response->successful()) {
            throw new \Exception(
                'Gagal upload dokumen ke Supabase: ' . $response->body()
            );
        }

        return $fileName;
    }

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
            $data['dokumen'] = $this->uploadToSupabase(
                $request->file('dokumen')
            );
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
            $data['dokumen'] = $this->uploadToSupabase(
                $request->file('dokumen')
            );
        }

        $skkh->update($data);

        return redirect()
            ->route('skkh.index')
            ->with('success', 'Data SKKH berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $skkh = Skkh::findOrFail($id);

        $skkh->delete();

        return redirect()
            ->route('skkh.index')
            ->with('success', 'Data SKKH berhasil dihapus!');
    }
}