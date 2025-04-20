@extends('layout.app')

@section('title', 'Mengedit User')

@section('content')
    <div class="section-header">
        <h1>Edit User</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Form Edit User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Masukkan nama user" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_pegawai">Nomor Pegawai</label>
                        <input type="text" class="form-control @error('nomor_pegawai') is-invalid @enderror"
                            id="nomor_pegawai" name="nomor_pegawai" placeholder="Masukkan nomor pegawai"
                            value="{{ old('nomor_pegawai', $user->nomor_pegawai) }}">
                        @error('nomor_pegawai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Masukkan email" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Masukkan password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control @error('level') is-invalid @enderror" id="level" name="level">
                            <option value="" disabled selected>Pilih level</option>
                            <option value="admin" {{ old('level', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('level', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- button --}}
                    <div class="tw-mt-4 tw-flex tw-justify-between">
                        <a href="{{ route('user.index') }}" class="btn btn-danger">Keluar</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
