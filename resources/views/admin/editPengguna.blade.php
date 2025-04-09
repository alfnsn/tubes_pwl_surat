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
                    @if($user->role->name == 'Mahasiswa')
                        <label for="id">NRP</label>
                        <input type="text" class="form-control" id="id" name="nrp" value="{{ $user->id }}" readonly>
                    @elseif($user->role->name == 'Kaprodi')
                        <label for="id">NIK</label>
                        <input type="text" class="form-control" id="id" name="nik" value="{{ $user->id }}" readonly>
                    @elseif($user->role->name == 'MO')
                        <label for="id">NIP</label>
                        <input type="text" class="form-control" id="id" name="nip" value="{{ $user->id }}" readonly>
                    @else
                        <label for="id">ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $user->id }}" readonly>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ $user->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="study_program">Study Program</label>
                    <input type="text" class="form-control" id="study_program" name="study_program_id" value="{{ $user->studyProgram->nama }}" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Leave blank to keep current password">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" name="role" value="{{ $user->role->name }}" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

</div>
@endsection