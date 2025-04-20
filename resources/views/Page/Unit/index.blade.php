@extends('layout.app')

@section('title', 'Unit')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select.bootstrap4.min.css') }}">
    <style>
        table.dataTable thead th {
            font-size: 16px;
        }

        /* Membesarkan tulisan isi data */
        table.dataTable tbody td {
            font-size: 15px;
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
        <h1>Daftar Unit</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                {{-- Isi konten --}}
                {{-- button create data arsip --}}
                <div class="tw-flex tw-justify-end tw-mb-4">
                    <a href="{{ route('unit.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data Unit
                    </a>
                </div>
                {{-- Tabel dataTables data arsip 20 data --}}
                <table id="unitTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/select.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
        });
        let table = $('#unitTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: {
                url: '{{ route('unit.data') }}',
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
                    data: 'unit_kerja',
                    name: 'unit_kerja'
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
                searchPlaceholder: "Cari Nama Unit",
                lengthMenu: "Tampilkan _MENU_ Data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ Data"
            }
        });
    </script>
@endpush
