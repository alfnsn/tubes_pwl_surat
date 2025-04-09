<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Pengguna</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('assetsadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assetsadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('assetsadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebarAdmin')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('layouts.navAdmin')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-2 text-gray-800">
                            @if(request()->is('pengguna/mahasiswa'))
                                Mahasiswa
                            @elseif(request()->is('pengguna/kaprodi'))
                                Kaprodi
                            @elseif(request()->is('pengguna/mo'))
                                MO
                            @elseif(request()->is('pengguna/admin'))
                                Admin
                            @endif
                        </h1>
                        @if(request()->is('pengguna/mahasiswa'))
                            <a href="{{ route('admin.pengguna.create', ['role' => 'Mahasiswa']) }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Add Mahasiswa</span>
                            </a>
                        @elseif(request()->is('pengguna/kaprodi'))
                            <a href="{{ route('admin.pengguna.create', ['role' => 'Kaprodi']) }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Add Kaprodi</span>
                            </a>
                        @elseif(request()->is('pengguna/mo'))
                            <a href="{{ route('admin.pengguna.create', ['role' => 'MO']) }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Add MO</span>
                            </a>
                        @elseif(request()->is('pengguna/admin'))
                            <a href="{{ route('admin.pengguna.create', ['role' => 'Admin']) }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Add Admin</span>
                            </a>
                        @endif
                    </div>
                    <p class="mb-4">
                        Berikut adalah data 
                        @if(request()->is('pengguna/mahasiswa'))
                            mahasiswa
                        @elseif(request()->is('pengguna/kaprodi'))
                            kaprodi
                        @elseif(request()->is('pengguna/mo'))
                            MO
                        @elseif(request()->is('pengguna/admin'))
                            admin
                        @endif
                        yang terdaftar dalam sistem.
                    </p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Data 
                                @if(request()->is('pengguna/mahasiswa'))
                                    Mahasiswa
                                @elseif(request()->is('pengguna/kaprodi'))
                                    Kaprodi
                                @elseif(request()->is('pengguna/mo'))
                                    MO
                                @elseif(request()->is('pengguna/admin'))
                                    Admin
                                @endif
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Study Program</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>{{ $user->status }}</td>
                                                @if($user->role->name != 'Admin')
                                                    <td>{{ $user->studyProgram->nama }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td style="white-space: nowrap; text-align:center;">
                                                    <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="btn btn-warning btn-circle btn-sm" style="display: inline-block;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            {{-- <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer --> --}}
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- <!-- Logout Modal-->
    @include('layouts.logout-modal') --}}

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assetsadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assetsadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assetsadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assetsadmin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assetsadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assetsadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
        });

        function showDeleteModal(action) {
            var form = document.getElementById('deleteForm');
            form.action = action;
            $('#deleteModal').modal('show');
        }
    </script>
</body>

</html>
