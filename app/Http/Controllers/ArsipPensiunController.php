<?php

namespace App\Http\Controllers;

use App\Models\ArsipPensiun;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipPensiunController extends Controller
{

    public function create()
    {
        $unitKerja = UnitKerja::select('id', 'unit_kerja')->get();
        return view('Page.ArsipPensiun.create', compact('unitKerja'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'nomor_pegawai' => 'required|string',
            'nomor_sk' => 'required|string',
            'unit_kerja' => 'required|exists:unit_kerja,id',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'surat1' => 'file|mimes:pdf|max:1024',
            'surat2' => 'file|mimes:pdf|max:1024',
        ]);

        // Handle file upload
        if ($request->hasFile('surat1')) {
            $file = $request->file('surat1');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen', $filename, 'local');
            $validate['dokumen1'] = 'dokumen/' . $filename;
        }

        if ($request->hasFile('surat2')) {
            $file = $request->file('surat2');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen', $filename, 'local');
            $validate['dokumen2'] = 'dokumen/' . $filename;
        }


        // Store the record in the database
        $arsipPensiun = new ArsipPensiun();
        $arsipPensiun->nama = $validate['nama'];
        $arsipPensiun->nomor_sk = $validate['nomor_sk'];
        $arsipPensiun->nomor_pegawai = $validate['nomor_pegawai'];
        $arsipPensiun->unit_kerja = $validate['unit_kerja'];
        $arsipPensiun->tanggal_surat = $validate['tanggal_surat'];
        $arsipPensiun->tanggal_diterima = $validate['tanggal_diterima'];
        $arsipPensiun->dokumen1 = $validate['dokumen1'] ?? null;
        $arsipPensiun->dokumen2 = $validate['dokumen2'] ?? null;
        $arsipPensiun->save();

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $arsip = ArsipPensiun::findOrFail($id);
        $unitKerja = UnitKerja::select('id', 'unit_kerja')->get();

        return response()->json([
            'id' => $arsip->id,
            'nama' => $arsip->nama,
            'nomor_pegawai' => $arsip->nomor_pegawai,
            'nomor_sk' => $arsip->nomor_sk,
            'unit_kerja' => $arsip->unit_kerja,
            'tanggal_surat' => $arsip->tanggal_surat,
            'tanggal_diterima' => Carbon::parse($arsip->tanggal_diterima)->format('Y-m-d'),
            'dokumen1' => $arsip->dokumen1 ? route('arsip.download', ['filename' => basename($arsip->dokumen1)]) : null,
            'dokumen2' => $arsip->dokumen2 ? route('arsip.download', ['filename' => basename($arsip->dokumen2)]) : null,
            'unitKerja' => [
                'id' => $unitKerja->pluck('id'),
                'unit_kerja' => $unitKerja->pluck('unit_kerja'),
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:100',
            'unit_kerja' => 'required|exists:unit_kerja,id',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'dokumen1' => 'nullable|mimes:pdf|max:10240',
            'dokumen2' => 'nullable|mimes:pdf|max:10240',
        ]);

        $arsip = ArsipPensiun::findOrFail($id);
        $arsip->nama = $validated['nama'];
        $arsip->nomor_sk = $validated['nomor_sk'];
        $arsip->unit_kerja = $validated['unit_kerja'];
        $arsip->tanggal_surat = $validated['tanggal_surat'];
        $arsip->tanggal_diterima = $validated['tanggal_diterima'];

        // handle file upload
        if ($request->hasFile('dokumen1')) {
            if ($arsip->dokumen1) {
                Storage::disk('local')->delete($arsip->dokumen1);
            }
            $file = $request->file('dokumen1');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen', $filename, 'local');
            $arsip->dokumen1 = 'dokumen/' . $filename;
        }

        if ($request->hasFile('dokumen2')) {
            if ($arsip->dokumen2) {
                Storage::disk('local')->delete($arsip->dokumen2);
            }
            $file = $request->file('dokumen2');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen', $filename, 'local');
            $arsip->dokumen2 = 'dokumen/' . $filename;
        }
        // Save the updated record

        $arsip->save();

        if ($arsip) {
            return redirect()->route('dashboard')->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->route('dashboard')->with('error', 'Data gagal diubah');
        }
    }

    public function view($id)
    {
        return view('Page.show-arsip-pensiun', compact('id'));
    }

    public function destroy($id)
    {
        $arsip = ArsipPensiun::findOrFail($id);

        if ($arsip->dokumen1) {
            Storage::disk('public')->delete($arsip->dokumen1);
        }

        if ($arsip->dokumen2) {
            Storage::disk('public')->delete($arsip->dokumen2);
        }

        $arsip->delete();

        // return view
        if ($arsip) {
            return redirect()->route('dashboard')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('dashboard')->with('error', 'Data gagal dihapus');
        }
    }

    public function download($filename)
    {
        $path = storage_path('app/private/dokumen/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
