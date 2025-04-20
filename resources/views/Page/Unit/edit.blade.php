@extends('layout.app')
@section('title', 'Mengedit Unit')
@section('content')
    <div class="section-header">
        <h1>Unit</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Form Edit Unit</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('unit.update', ['id' => $unitKerja->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="unit">Nama Unit</label>
                        <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                            name="unit" placeholder="Masukkan nama unit" value="{{ old('unit', $unitKerja->unit_kerja) }}">
                        @error('unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="tw-mt-4 tw-flex tw-justify-between">
                        <a href="{{ route('unit.index') }}" class="btn btn-danger">Keluar</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
