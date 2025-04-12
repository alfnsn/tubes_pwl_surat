@extends('layouts.indexAdmin')

@section('content')
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Mata Kuliah</h1>
            <a href="{{ route('admin.mataKuliah.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Mata Kuliah</span>
            </a>
        </div>
        <p class="mb-4">Berikut adalah data Mata Kuliah yang terdaftar dalam sistem.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Mata Kuliah</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mataKuliah as $mk)
                                <tr>
                                    <td>{{ $mk->idmata_kuliah }}</td>
                                    <td>{{ $mk->nama }}</td>
                                    <td style="white-space: nowrap;">
                                        <a href="{{ route('admin.mataKuliah.edit', ['id' => $mk->idmata_kuliah]) }}"
                                            class="btn btn-warning btn-circle btn-sm d-flex justify-content-center align-items-center"
                                            style="margin: 0 auto;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-action="{{ route('admin.mataKuliah.destroy', ['id' => $mk->idmata_kuliah]) }}">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus mata kuliah ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var action = button.data('action'); // Extract info from data-* attributes
                var form = document.getElementById('deleteForm');
                form.action = action; // Set the action attribute of the form
            });
        });
    </script>
@endsection
