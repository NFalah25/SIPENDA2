@extends('layout.app')

@section('title', 'Membuat User')

@section('content')
    <div class="section-header">
        <h1>Tambah User</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                {{-- Isi konten --}}
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                            @error('name')
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
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password"
                                @error('password')>
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                                </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select class="form-control @error('level') is-invalid @enderror" id="level"
                                    name="level">
                                    <option value="">Pilih Level</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
