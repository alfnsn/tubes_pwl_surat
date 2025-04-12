@extends('layouts.indexAdmin')

@section('content')
    <div class="container-fluid">

        {{-- <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add {{ $role }}</h1> --}}

        <!-- Form Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add {{ $role }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="id">
                            @if ($role == 'Mahasiswa')
                                NRP
                            @elseif($role == 'Kaprodi')
                                NIM
                            @elseif($role == 'MO')
                                NIK
                            @else
                                NIK
                            @endif
                        </label>
                        <input type="text" class="form-control" id="id" name="id" maxlength="9"
                            value="{{ old('id') }}" required>
                        @error('id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="120"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="45"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" maxlength="255" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            maxlength="255" required>
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" maxlength="300"
                            value="{{ old('address') }}" required>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($role != 'Admin')
                        <div class="form-group">
                            <label for="study_program">Program Studi</label>
                            <select class="form-control" id="study_program" name="study_program_id" required>
                                <option value="">Pilih Program Studi</option>
                                @foreach ($studyPrograms as $studyProgram)
                                    <option value="{{ $studyProgram->idstudy_program }}"
                                        {{ old('study_program_id') == $studyProgram->idstudy_program ? 'selected' : '' }}>
                                        {{ $studyProgram->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="16"
                            value="{{ old('phone') }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <input type="hidden" name="role_id" value="{{ $roleId }}">
                    <input type="hidden" name="role" value="{{ $role }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
@endsection
