@extends('layout.app')

@section('title', 'Create Arsip Pensiun')

@push('styles')
    <style>
        .custom-file-upload {
            display: inline-block;
            padding: 8px 20px;
            cursor: pointer;
            background-color: #607D8B;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .custom-file-upload:hover {
            background-color: #4b616c;
        }

        input[type="file"] {
            display: none;
        }

        #preview-container {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #333;
        }

        .pdf-icon {
            width: 24px;
            height: 24px;
        }
    </style>
@endpush

@section('content')
    <div class="section-header">
        <h1>Membuat Arsip Pensiun</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Form Tambah Data Arsip Pensiun</h4>
            </div>
            <div class="card-body">
                {{-- form input data arsip pensiun --}}
                <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama') }}" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_pegawai">Nomor Pegawai</label>
                        <input type="text" class="form-control @error('nomor_pegawai') is-invalid @enderror"
                            id="nomor_pegawai" name="nomor_pegawai" value="{{ old('nomor_pegawai') }}">
                        @error('nomor_pegawai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_sk">Nomor SK</label>
                        <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror" id="nomor_sk"
                            name="nomor_sk" value="{{ old('nomor_sk') }}" value="{{ old('nomor_sk') }}">
                        @error('nomor_sk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="unit_kerja">Unit Kerja</label>
                        <select class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
                            name="unit_kerja">
                            <option value="">Pilih Unit Kerja</option>
                            @foreach ($unitKerja as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_kerja') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_kerja }}</option>
                            @endforeach
                        </select>
                        @error('unit_kerja')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_surat">Tanggal Surat</label>
                        <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror"
                            id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}">
                        @error('tanggal_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_diterima">Tanggal Diterima</label>
                        <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror"
                            id="tanggal_diterima" name="tanggal_diterima" value="{{ old('tanggal_diterima') }}">
                        @error('tanggal_diterima')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- upload document --}}
                    <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-gap-4">
                        <!-- Surat 1 -->
                        <div class="md:tw-w-1/2 tw-mb-4">
                            <label class="tw-block tw-mb-2 tw-font-semibold">Upload Surat 1 (PDF)</label>
                            <label class="custom-file-upload">
                                <input type="file" id="surat1" name="surat1" accept="application/pdf">
                                Pilih Surat 1
                            </label>
                            <div id="preview-surat1" class="preview-container"></div>
                            @error('surat1')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Surat 2 -->
                        <div class="md:tw-w-1/2 tw-mb-4">
                            <label class="tw-block tw-mb-2 tw-font-semibold">Upload Surat 2 (PDF)</label>
                            <label class="custom-file-upload">
                                <input type="file" id="surat2" name="surat2" accept="application/pdf">
                                Pilih Surat 2
                            </label>
                            <div id="preview-surat2" class="preview-container"></div>
                            @error('surat2')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- back --}}
                    <div class="tw-mt-4 tw-flex tw-justify-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-danger">Keluar</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function handleFileInput(inputId, previewId) {
            document.getElementById(inputId).addEventListener('change', function(event) {
                let previewContainer = document.getElementById(previewId);
                previewContainer.innerHTML = '';

                let file = event.target.files[0];
                if (!file) return;

                if (file.type === 'application/pdf') {
                    let img = document.createElement('img');
                    img.src = 'https://cdn-icons-png.flaticon.com/512/337/337946.png'; // Icon PDF
                    img.className = 'pdf-icon';

                    let fileName = document.createElement('span');
                    fileName.textContent = file.name;

                    previewContainer.appendChild(img);
                    previewContainer.appendChild(fileName);
                } else {
                    previewContainer.innerHTML = "<p class='text-danger'>Hanya file PDF yang diizinkan!</p>";
                    this.value = ""; // Reset input jika bukan PDF
                }
            });
        }

        handleFileInput('surat1', 'preview-surat1');
        handleFileInput('surat2', 'preview-surat2');
    </script>
@endpush
