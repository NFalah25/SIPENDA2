@extends('layout.app')

@section('title', 'Dashboard')
@push('styles')
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select.bootstrap4.min.css') }}">
    <style>
        /* Membesarkan tulisan header tabel */
        table.dataTable thead th {
            font-size: 16px;
        }

        /* Membesarkan tulisan isi data */
        table.dataTable tbody td {
            font-size: 15px;
        }

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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    <div class="section-header">
        <h1>Beranda</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="md:tw-flex tw-flex-row tw-justify-center tw-w-full tw-items-center tw-gap-14 tw-text-md">
                    {{-- Bagian Unit --}}
                    <div class="tw-flex tw-items-center tw-w-full md:tw-w-1/2 tw-space-x-4">
                        <h5 class="tw-whitespace-nowrap tw-w-20 md:tw-w-fit">Pencarian Unit</h5>
                        <form id="formFilterUnit" class="tw-flex tw-w-full tw-gap-2">
                            <select class="tw-w-full tw-border tw-rounded-xl tw-px-3" id="filterUnit" name="unit">
                                <option value="">Pilih Unit</option>
                                @foreach ($unitKerja as $uk)
                                    <option value="{{ $uk->id }}" @if ($uk->id == request('unit')) selected @endif>
                                        {{ $uk->unit_kerja }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Isi konten --}}
                {{-- button create data arsip --}}
                <div class="tw-flex tw-justify-end tw-mb-4">
                    <a href="{{ route('arsip.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data Arsip
                    </a>
                </div>
                {{-- Tabel dataTables data arsip 20 data --}}
                <table id="arsipTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nomor SK</th>
                            <th>Unit Kerja</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
                            <th>Update Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-arsip-pensiun"></div>
    <div id="modal-2"></div>
    {{-- <div id="formEditTemplate" style="display: none;">
        <form id="fireEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="editId" name="id">

            <div class="form-group">
                <label for="editNama">Nama</label>
                <input type="text" class="form-control" id="editNama" name="nama">
            </div>
            <div class="form-group">
                <label for="editNomorPegawai">Nomor Pegawai</label>
                <input type="text" class="form-control" id="editNomorPegawai" name="nomor_pegawai">
            </div>
            <div class="form-group">
                <label for="editNomorSk">Nomor SK</label>
                <input type="text" class="form-control" id="editNomorSk" name="nomor_sk">
            </div>
            <div class="form-group">
                <label for="editUnitKerja">Unit Kerja</label>
                <select class="form-control" id="editUnitKerja" name="unit_kerja">
                    <option value="">Pilih Unit Kerja</option>
                    @foreach ($unitKerja as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit_kerja }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="editTanggalSurat">Tanggal Surat</label>
                <input type="date" class="form-control" id="editTanggalSurat" name="tanggal_surat">
            </div>
            <div class="form-group">
                <label for="editTanggalDiterima">Tanggal Diterima</label>
                <input type="date" class="form-control" id="editTanggalDiterima" name="tanggal_diterima">
            </div>
            <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-gap-4">
                <div class="md:tw-w-1/2 tw-mb-4">
                    <label class="tw-block tw-mb-2 tw-font-semibold">Upload Surat 1 (PDF)</label>
                    <input type="file" id="editSurat1" name="surat1" accept="application/pdf" class="form-control">
                </div>
                <div class="md:tw-w-1/2 tw-mb-4">
                    <label class="tw-block tw-mb-2 tw-font-semibold">Upload Surat 2 (PDF)</label>
                    <input type="file" id="editSurat2" name="surat2" accept="application/pdf" class="form-control">
                </div>
            </div>
            <div class="tw-mt-4 tw-flex tw-justify-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div> --}}
    <div id="formEditTemplate" style="display:none;">
        <form id="fireEditForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editId" name="id">

            <div class="form-group">
                <label for="editNama">Nama</label>
                <input type="text" class="form-control" id="editNama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="editNomorSk">Nomor SK</label>
                <input type="text" class="form-control" id="editNomorSk" name="nomor_sk" required>
            </div>

            <div class="form-group">
                <label for="editUnitKerja">Unit Kerja</label>
                <input type="text" class="form-control" id="editUnitKerja" name="unit_kerja" required>
            </div>

            <div class="form-group">
                <label for="editTanggalSurat">Tanggal Surat</label>
                <input type="date" class="form-control" id="editTanggalSurat" name="tanggal_surat" required>
            </div>

            <div class="form-group">
                <label for="editTanggalDiterima">Tanggal Diterima</label>
                <input type="date" class="form-control" id="editTanggalDiterima" name="tanggal_diterima" required>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/prism.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
    <script>
        // 3 detik
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
            let table = $('#arsipTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: '{{ route('arsip.pensiun.data') }}',
                    data: function(d) {
                        d.unit = $('#filterUnit').val(); // ambil dari dropdown unit
                        console.log(d.unit);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nomor_sk',
                        name: 'nomor_sk'
                    },
                    {
                        data: 'unit_kerja',
                        name: 'unit_kerja'
                    },
                    {
                        data: 'tanggal_surat',
                        name: 'tanggal_surat'
                    },
                    {
                        data: 'tanggal_diterima',
                        name: 'tanggal_diterima'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                language: {
                    search: "Pencarian: _INPUT_",
                    searchPlaceholder: "Cari Nama, Nomor SK...",
                    lengthMenu: "Tampilkan _MENU_ Data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ Data"
                }
            });
            $('#unitFilter').on('change', function() {
                table.ajax.reload();
            });
        });

        // $(document).on('click', '.editBtn', function() {
        //     let id = $(this).data('id');

        //     $.ajax({
        //         url: '/arsip-pensiun/edit/' + id,
        //         type: 'GET',
        //         success: function(data) {
        //             let modal = $("#modal-2").fireModal({
        //                 title: "Edit Arsip Pensiun",
        //                 body: $('#formEditTemplate').html(),
        //                 center: true,
        //                 buttons: [{
        //                         text: 'Batal',
        //                         class: 'btn btn-danger',
        //                         handler: function(modal) {
        //                             $(modal).modal('hide');
        //                         }
        //                     },
        //                     {
        //                         text: 'Simpan',
        //                         class: 'btn btn-primary',
        //                         handler: function(modal) {
        //                             $('#fireEditForm').submit();
        //                         }
        //                     }
        //                 ]
        //             }, true);

        //             setTimeout(function() {
        //                 let currentModal = $('.modal.show');

        //                 currentModal.find('#editId').val(data.id);
        //                 currentModal.find('#editNama').val(data.nama);
        //                 currentModal.find('#editNomorPegawai').val(data.nomor_pegawai);
        //                 currentModal.find('#editNomorSk').val(data.nomor_sk);
        //                 currentModal.find('#editUnitKerja').val(data.unit_kerja);
        //                 currentModal.find('#editTanggalSurat').val(data.tanggal_surat);
        //                 currentModal.find('#editTanggalDiterima').val(data.tanggal_diterima);
        //             }, 300);

        //         },
        //         error: function() {
        //             alert('Gagal memuat data.');
        //         }
        //     });
        // });



        $('#editForm').submit(function(e) {
            e.preventDefault();
            let id = $('#editId').val();
            let formData = new FormData(this);

            $.ajax({
                url: '/arsip-pensiun/' + id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#arsipTable').DataTable().ajax.reload();
                    alert('Data berhasil diupdate!');
                },
                error: function(xhr) {
                    alert('Update gagal! Silakan cek data.');
                }
            });
        });



        function hapusData(id) {
            if (confirm("Apakah kamu yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: '/arsip-pensiun/delete/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#arsipTable').DataTable().ajax.reload(); // refresh table setelah delete
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus data!');
                    }
                });
            }
        }
    </script>
@endpush
