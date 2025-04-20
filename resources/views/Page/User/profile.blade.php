@extends('layout.app')
@section('title', 'User Profile')

@section('content')
    <div class="section-header">
        <h1>User Profile</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>User Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" required=""
                            placeholder="Masukkan nama" value="{{ old('name', $user->name) }}" name="name" readonly>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>Nomor Pegawai</label>
                        <input type="text" class="form-control" placeholder="Masukkan nomor pegawai"
                            value="{{ old('nomor_pegawai', $user->nomor_pegawai) }}" name="nomor_pegawai" readonly>
                        @error('nomor_pegawai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Email</label>
                        <input type="email" class="form-control" required="" placeholder="Masukkan email"
                            value="{{ old('email', $user->email) }}" name="email" readonly>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>Level</label>
                        <input type="text" class="form-control" value="{{ old('level', $user->role) }}" name="level" required
                            readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
