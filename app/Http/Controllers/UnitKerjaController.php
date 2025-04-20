<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Http\Requests\StoreUnitKerjaRequest;
use App\Http\Requests\UpdateUnitKerjaRequest;
use Yajra\DataTables\DataTables;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unitKerja = UnitKerja::select('id', 'unit_kerja')->get();
        return view('Page.Unit.index', compact('unitKerja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Page.Unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitKerjaRequest $request)
    {
        $validated = $request->validated();
        $unitKerja = new UnitKerja();
        $unitKerja->unit_kerja = $validated['unit'];
        $unitKerja->save();
        return redirect()->route('unit.index')->with('success', 'Unit Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitKerja $unitKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unitKerja = UnitKerja::find($id);
        return view('Page.Unit.edit', compact('unitKerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $validated = request()->validate([
            'unit' => 'required|string|max:255',
        ]);
        $unitKerja = UnitKerja::find($id);
        if (!$unitKerja) {
            return redirect()->route('unit.index')->with('error', 'Unit tidak ditemukan');
        }
        $unitKerja->unit_kerja = $validated['unit'];
        $unitKerja->save();
        return redirect()->route('unit.index')->with('success', 'Unit Berhasil diubah');
    }
    public function destroy($id)
    {
        $unitKerja = UnitKerja::find($id);
        if (!$unitKerja) {
            return redirect()->route('unit.index')->with('error', 'Unit tidak ditemukan');
        }
        // Hapus unit kerja
        $unitKerja->delete();
        return redirect()->route('unit.index')->with('success', 'Unit Berhasil dihapus');
    }

    public function getUnitKerja()
    {
        $unitKerja = UnitKerja::select('id', 'unit_kerja')->get();
        return DataTables::of($unitKerja)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $editBtn = '<a href="' . route('unit.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $deleteBtn = '
                <form action="' . route('unit.destroy', $row->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure?\')">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
