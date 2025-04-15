@extends('layouts.indexAdmin')

@section('content')
    <div class="container-fluid">

        {{-- <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Pengguna</h1> --}}

        <!-- Form Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Pengguna</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        @if ($user->role->name == 'Mahasiswa')
                            <label for="id">NRP</label>
                            <input type="text" class="form-control" id="id" name="nrp"
                                value="{{ $user->id }}" readonly>
                        @elseif($user->role->name == 'Kaprodi')
                            <label for="id">NIK</label>
                            <input type="text" class="form-control" id="id" name="nik"
                                value="{{ $user->id }}" readonly>
                        @elseif($user->role->name == 'MO')
                            <label for="id">NIP</label>
                            <input type="text" class="form-control" id="id" name="nip"
                                value="{{ $user->id }}" readonly>
                        @else
                            <label for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="id"
                                value="{{ $user->id }}" readonly>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address', $user->address) }}" required>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="tidak aktif"
                                {{ old('status', $user->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="study_program">Program Study</label>
                        <input type="text" class="form-control" id="study_program" name="study_program_id"
                            value="{{ $user->studyProgram->nama }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Biarkan kosong jika tidak ingin diubah">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Masukkan kembali password">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        @if ($user->role->name == 'Dosen')
                            <select class="form-control" id="role" name="role_id" required>
                                <option value="dosen"
                                    {{ old('role_id', $user->role->name) == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="kaprodi"
                                    {{ old('role_id', $user->role->name) == 'Kaprodi' ? 'selected' : '' }}>Kaprodi
                                </option>
                            </select>
                        @else
                            <input type="text" class="form-control" id="role" name="role"
                                value="{{ $user->role->name }}" readonly>
                        @endif
                        @error('role_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

    </div>
@endsection
