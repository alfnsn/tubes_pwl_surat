@extends('layouts.indexAdmin')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Pengantar Tugas Mata Kuliah</h1>
        <a href="{{ route('admin.createPengantarTugasMataKuliah') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Pengantar Tugas Mata Kuliah</span>
        </a>
    </div>
    <p class="mb-4">Berikut adalah data pengantar tugas mata kuliah yang terdaftar dalam sistem.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengantar Tugas Mata Kuliah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Mahasiswa</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengantarTugasMataKuliah as $item)
                            <tr>
                                <td>{{ $item->user->id }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->tanggal_pengajuan }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->disetujui_oleh ?? 'Belum Disetujui' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
