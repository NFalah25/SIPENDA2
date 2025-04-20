<?php

namespace App\Http\Controllers;

use App\Models\ArsipPensiun;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $unitKerja = UnitKerja::select('id', 'unit_kerja')->get();
        return view('Page.dashboard', compact('unitKerja'));
    }

    public function getArsipPensiun(Request $request)
    {
        // $query = ArsipPensiun::select('id', 'nama', 'updated_at', 'nomor_sk', 'unit_kerja', 'tanggal_surat', 'tanggal_diterima')
        //     ->orderBy('updated_at', 'desc');
        $query = DB::table('arsip_pensiun')
            ->join('unit_kerja', 'arsip_pensiun.unit_kerja', '=', 'unit_kerja.id')
            ->select(
                'arsip_pensiun.id',
                'arsip_pensiun.nama',
                'arsip_pensiun.updated_at',
                'arsip_pensiun.nomor_sk',
                'unit_kerja.unit_kerja as unit_kerja',
                'arsip_pensiun.tanggal_surat',
                'arsip_pensiun.tanggal_diterima',
                'arsip_pensiun.dokumen1',
                'arsip_pensiun.dokumen2'
            )
            ->orderBy('updated_at', 'desc');

        if ($request->unit) {
            $query = DB::table('arsip_pensiun')
            ->join('unit_kerja', 'arsip_pensiun.unit_kerja', '=', 'unit_kerja.id')
            ->select(
                'arsip_pensiun.id',
                'arsip_pensiun.nama',
                'arsip_pensiun.updated_at',
                'arsip_pensiun.nomor_sk',
                'unit_kerja.unit_kerja as unit_kerja',
                'arsip_pensiun.tanggal_surat',
                'arsip_pensiun.tanggal_diterima',
                'arsip_pensiun.dokumen1',
                'arsip_pensiun.dokumen2'
            )
            ->where('arsip_pensiun.unit_kerja', $request->unit)
            ->orderBy('updated_at', 'desc');
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->format('d-m-Y');
            })
            ->editColumn('tanggal_diterima', function ($row) {
                return Carbon::parse($row->tanggal_diterima)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                // $viewBtn = '<a href="' . route("arsip.view", ['id' => $row->id]) . '" class="btn btn-info btn-sm">View</a>';
                $viewBtn = '
                                <div class="dropdown d-inline mr-2">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Lihat Dokumen
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">';

                if ($row->dokumen1) {
                    $viewBtn .= '<a class="dropdown-item" href="' . route("arsip.download", ['filename' => basename($row->dokumen1)]) . '" target="_blank">
                                                    <i class="fas fa-file-pdf text-danger"></i> Dokumen 1
                                                </a>';
                }
                if ($row->dokumen2) {
                    $viewBtn .= '<a class="dropdown-item" href="' . route("arsip.download", ['filename' => basename($row->dokumen2)]) . '" target="_blank">
                                                    <i class="fas fa-file-pdf text-danger"></i> Dokumen 2
                                                </a>';
                }
                if (!$row->dokumen1 && !$row->dokumen2) {
                    $viewBtn .= '<a class="dropdown-item text-danger" href="#">
                                                        Tidak ada dokumen
                                                </a>';
                }
                $viewBtn .= '</div></div>';

                $editBtn = '<button class="btn btn-warning btn-sm editBtn" data-id="' . $row->id . '">Edit</button>';
                $deleteBtn = '
                <form action="' . route('arsip.destroy', $row->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure?\')">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>';
                return $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
