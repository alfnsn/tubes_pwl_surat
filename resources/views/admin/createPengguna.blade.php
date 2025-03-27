@extends('layouts.indexAdmin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add {{ $role }}</h1>

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
                        @if($role == 'Mahasiswa')
                            NRP
                        @elseif($role == 'Kaprodi')
                            NIM
                        @elseif($role == 'MO')
                            NIK
                        @else
                            ID
                        @endif
                    </label>
                    <input type="text" class="form-control" id="id" name="id" maxlength="9" required>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" maxlength="120" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" maxlength="45" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" maxlength="300" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" class="form-control" id="status" name="status" maxlength="12" required>
                </div>
                @if($role != 'Admin')
                <div class="form-group">
                    <label for="study_program">Study Program</label>
                    <select class="form-control" id="study_program" name="study_program_id" required>
                        <option value="">Select Study Program</option>
                        @foreach($studyPrograms as $studyProgram)
                            <option value="{{ $studyProgram->idstudy_program }}">{{ $studyProgram->nama }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" maxlength="16" required>
                </div>
                <input type="hidden" name="role_id" value="{{ $roleId }}">
                <input type="hidden" name="role" value="{{ $role }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
@endsection